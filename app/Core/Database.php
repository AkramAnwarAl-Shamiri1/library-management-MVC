<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    private string $host = '127.0.0.1';
    private string $db   = 'library_db';
    private string $user = 'root';
    private string $pass = '';
    private string $charset = 'utf8mb4';

    private function __construct() {}

   
     
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $db = new self();
            $dsn = "mysql:host={$db->host};dbname={$db->db};charset={$db->charset}";
            try {
                $pdo = new PDO($dsn, $db->user, $db->pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                    PDO::ATTR_EMULATE_PREPARES => false,             
                ]);
                self::$instance = $pdo;
            } catch (PDOException $e) {
               
                error_log('Database Connection Error: ' . $e->getMessage());
                throw new PDOException('Database connection failed.');
            }
        }
        return self::$instance;
    }
}
