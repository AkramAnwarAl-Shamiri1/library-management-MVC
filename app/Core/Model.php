<?php
namespace App\Core;

use PDO;

class Model {
    protected PDO $db;
    protected string $table = '';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    
    public function all(): array {
        if (empty($this->table)) {
            throw new \Exception('Table name not set in model.');
        }

        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

   
    
    public function find(int $id): ?array {
        if (empty($this->table)) {
            throw new \Exception('Table name not set in model.');
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
