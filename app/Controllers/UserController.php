<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller {
    private User $userModel;
    private array $segments;

    public function __construct() {
        $this->userModel = new User();
        global $segments;
        $this->segments = $segments;
    }

    public function index(): void {
        $users = $this->userModel->all();
        $this->view('users/list.php', ['users' => $users]);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'  => htmlspecialchars(trim($_POST['name'] ?? '')),
                'email' => htmlspecialchars(trim($_POST['email'] ?? ''))
            ];

            if (empty($data['name']) || empty($data['email'])) {
                $this->redirect('/user/create');
                return;
            }

            $this->userModel->create($data);
            $this->redirect('/user/index'); 
        }

        $this->view('users/form.php');
    }

    public function edit(): void {
        $id = (int)($this->segments[2] ?? 0); 
        if ($id <= 0) {
            $this->redirect('/user/index');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            $this->redirect('/user/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'  => htmlspecialchars(trim($_POST['name'] ?? '')),
                'email' => htmlspecialchars(trim($_POST['email'] ?? ''))
            ];

            if (empty($data['name']) || empty($data['email'])) {
                $this->redirect("/user/edit/{$id}");
                return;
            }

            $this->userModel->update($id, $data);
            $this->redirect('/user/index');
        }

        $this->view('users/form.php', ['user' => $user]);
    }

    public function delete(): void {
        $id = (int)($this->segments[2] ?? 0); 
        if ($id > 0) {
            $this->userModel->delete($id);
        }
        $this->redirect('/user/index'); 
    }
}
