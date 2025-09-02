<?php
namespace App\Models;

use App\Core\Model;
use App\Traits\LoggingTrait;
use App\Interfaces\NotificationInterface;

class Borrow extends Model {
    use LoggingTrait;

    protected string $table = 'borrows';

   
    public function borrowBook(int $userId, int $bookId, \DateTime $dueDate, NotificationInterface $notifier, string $userContact): bool {
        try {
            $this->db->beginTransaction();

            
            $stmt = $this->db->prepare('SELECT available_copies FROM books WHERE id = :id FOR UPDATE');
            $stmt->execute(['id'=>$bookId]);
            $book = $stmt->fetch();

            if (!$book || (int)$book['available_copies'] <= 0) {
                $this->db->rollBack();
                return false;
            }

            
            $stmt = $this->db->prepare('INSERT INTO borrows (user_id, book_id, due_date) VALUES (:user,:book,:due)');
            $stmt->execute([
                'user'=>$userId, 
                'book'=>$bookId, 
                'due'=>$dueDate->format('Y-m-d H:i:s')
            ]);

          
            $stmt = $this->db->prepare('UPDATE books SET available_copies = available_copies - 1 WHERE id = :id');
            $stmt->execute(['id'=>$bookId]);

            
            $stmt = $this->db->prepare('UPDATE users SET borrowed_count = borrowed_count + 1 WHERE id = :id');
            $stmt->execute(['id'=>$userId]);

            $this->db->commit();

          
            $notifier->send($userContact, "You borrowed book ID={$bookId}. Due on " . $dueDate->format('Y-m-d'));

            $this->log("Borrow success: user={$userId}, book={$bookId}");
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            $this->log('Borrow failed: ' . $e->getMessage());
            return false;
        }
    }

   
    public function returnBook(int $borrowId): ?float {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare('SELECT * FROM borrows WHERE id=:id FOR UPDATE');
            $stmt->execute(['id'=>$borrowId]);
            $borrow = $stmt->fetch();

            if (!$borrow || $borrow['status'] === 'returned') {
                $this->db->rollBack();
                return null;
            }

            $now = new \DateTime();
            $due = new \DateTime($borrow['due_date']);
            $lateDays = max(0, $now->diff($due)->days);

            $stmt = $this->db->prepare('SELECT daily_late_fee FROM books WHERE id=:id');
            $stmt->execute(['id'=>$borrow['book_id']]);
            $bookRow = $stmt->fetch();
            $dailyFee = $bookRow ? (float)$bookRow['daily_late_fee'] : 0.0;
            $lateFee = $lateDays * $dailyFee;

            $stmt = $this->db->prepare('UPDATE borrows SET returned_at = :ret, late_fee = :fee, status = "returned" WHERE id = :id');
            $stmt->execute([
                'ret'=>$now->format('Y-m-d H:i:s'), 
                'fee'=>$lateFee, 
                'id'=>$borrowId
            ]);

          
            $stmt = $this->db->prepare('UPDATE books SET available_copies = available_copies + 1 WHERE id = :id');
            $stmt->execute(['id'=>$borrow['book_id']]);

            $stmt = $this->db->prepare('UPDATE users SET borrowed_count = GREATEST(borrowed_count - 1, 0) WHERE id = :id');
            $stmt->execute(['id'=>$borrow['user_id']]);

            $this->db->commit();
            $this->log("Return processed: borrow={$borrowId}, late_fee={$lateFee}");
            return $lateFee;

        } catch (\Exception $e) {
            $this->db->rollBack();
            $this->log('Return failed: ' . $e->getMessage());
            return null;
        }
    }

  
    public function all(): array {
        $stmt = $this->db->query(
            'SELECT b.*, u.name as user_name, bk.title as book_title 
             FROM borrows b 
             JOIN users u ON u.id = b.user_id 
             JOIN books bk ON bk.id = b.book_id 
             ORDER BY b.borrowed_at DESC'
        );
        return $stmt->fetchAll();
    }
}
