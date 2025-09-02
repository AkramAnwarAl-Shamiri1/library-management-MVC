<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;
use App\Notifications\EmailNotification;

class BorrowController extends Controller {
    private Borrow $borrowModel;
    private Book $bookModel;
    private User $userModel;

    public function __construct() {
        $this->borrowModel = new Borrow();
        $this->bookModel = new Book();
        $this->userModel = new User();
    }

    public function index(): void {
        $borrows = $this->borrowModel->all();
        $this->view('borrows/list.php', ['borrows' => $borrows]);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = (int)($_POST['user_id'] ?? 0);
            $bookId = (int)($_POST['book_id'] ?? 0);
            $dueDateInput = $_POST['due_date'] ?? '';

            if ($userId <= 0 || $bookId <= 0 || empty($dueDateInput)) {
                $this->redirect('/borrow/create');
                return;
            }

            try {
                $due = new \DateTime($dueDateInput);
            } catch (\Exception $e) {
                $this->redirect('/borrow/create');
                return;
            }

            $user = $this->userModel->find($userId);
            if (!$user) {
                $this->redirect('/borrow/create');
                return;
            }

            $contact = $user['email'] ?? 'unknown';
            $notifier = new EmailNotification();

            $success = $this->borrowModel->borrowBook($userId, $bookId, $due, $notifier, $contact);

            if ($success) {
                $this->redirect('/borrow/index'); 
            } else {
                $this->redirect('/borrow/create');
            }
        }

        $books = $this->bookModel->all();
        $users = $this->userModel->all();
        $this->view('borrows/form.php', ['books' => $books, 'users' => $users]);
    }

    public function returnBook($borrowId = 0): void {
        $borrowId = (int) $borrowId; 

        if ($borrowId <= 0) {
            $this->redirect('/borrow/index');
            return;
        }

        $lateFee = $this->borrowModel->returnBook($borrowId);

       
        $this->redirect('/borrow/index');
    }
}
