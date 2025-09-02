<?php
namespace App\Models;

use App\Core\Model;
use App\Traits\LoggingTrait;

class User extends Model {
    use LoggingTrait;

    protected string $table = 'users';

   
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res ?: null;
    }

   
    public function create(array $data): int {
        $sql = "INSERT INTO {$this->table} (name, email) VALUES (:name, :email)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name'  => $data['name'], 
            'email' => $data['email']
        ]);
        $this->log("User created: {$data['email']}");
        return (int)$this->db->lastInsertId();
    }

   
    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([
            'name'  => $data['name'],
            'email' => $data['email'],
            'id'    => $id
        ]);
        $this->log("User updated: id={$id}");
        return $res;
    }

    
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $res = $stmt->execute(['id' => $id]);
        $this->log("User deleted: id={$id}");
        return $res;
    }

 
    public function incrementBorrowedCount(int $userId): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET borrowed_count = borrowed_count + 1 WHERE id = :id"
        );
        return $stmt->execute(['id' => $userId]);
    }

   
    public function decrementBorrowedCount(int $userId): bool {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET borrowed_count = GREATEST(borrowed_count - 1, 0) WHERE id = :id"
        );
        return $stmt->execute(['id' => $userId]);
    }

   
    public function search(string $term): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE name LIKE :term OR email LIKE :term ORDER BY id DESC"
        );
        $stmt->execute(['term' => "%$term%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
