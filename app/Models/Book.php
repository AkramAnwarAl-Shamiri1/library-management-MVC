<?php
namespace App\Models;

use App\Core\Model;
use App\Traits\LoggingTrait;
use App\Traits\SearchableTrait;

class Book extends Model {
    use LoggingTrait, SearchableTrait;

    protected string $table = 'books';

    
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

   
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

   
    public function create(array $data): int {
        $sql = "INSERT INTO {$this->table} 
                (title, author, total_copies, available_copies, daily_late_fee) 
                VALUES (:title, :author, :total, :avail, :fee)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => htmlspecialchars(trim($data['title'] ?? '')),
            'author'=> htmlspecialchars(trim($data['author'] ?? '')),
            'total' => (int)($data['total_copies'] ?? 0),
            'avail' => (int)($data['available_copies'] ?? 0),
            'fee'   => (float)($data['daily_late_fee'] ?? 0.5)
        ]);
        $this->log("Book created: {$data['title']}");
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} 
                SET title=:title, author=:author, total_copies=:total, available_copies=:avail, daily_late_fee=:fee 
                WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([
            'title' => htmlspecialchars(trim($data['title'] ?? '')),
            'author'=> htmlspecialchars(trim($data['author'] ?? '')),
            'total' => (int)($data['total_copies'] ?? 0),
            'avail' => (int)($data['available_copies'] ?? 0),
            'fee'   => (float)($data['daily_late_fee'] ?? 0.5),
            'id'    => $id
        ]);
        $this->log("Book updated: id={$id}");
        return $res;
    }

   
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
        $res = $stmt->execute(['id' => $id]);
        $this->log("Book deleted: id={$id}");
        return $res;
    }

    public function searchBooks(string $term): array {
        return $this->search(htmlspecialchars(trim($term)), ['title','author']);
    }
}
