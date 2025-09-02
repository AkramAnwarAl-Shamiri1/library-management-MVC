<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Book;

class BookController extends Controller {
    private Book $bookModel;

    public function __construct() {
        $this->bookModel = new Book();
    }

    public function index(): void {
        $books = $this->bookModel->all();
        $this->view('books/list.php', ['books' => $books]);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->bookModel->create($_POST);
            $this->redirect('/book/index');
        }
        $this->view('books/form.php');
    }

    public function edit($id = 0): void {
        $id = (int)$id;
        if ($id <= 0) {
            $this->redirect('/book/index');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->bookModel->update($id, $_POST);
            $this->redirect('/book/index');
        }

        $book = $this->bookModel->find($id);
        if (!$book) {
            $this->redirect('/book/index');
        }

        $this->view('books/form.php', ['book' => $book]);
    }

    public function delete($id = 0): void {
        $id = (int)$id;
        if ($id > 0) $this->bookModel->delete($id);
        $this->redirect('/book/index');
    }
}
