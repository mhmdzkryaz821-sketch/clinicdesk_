<?php


class Database {
    private static $instance = null;
    private $conn;

   
    private function __construct() {
        $config = require __DIR__ . '/../config/database.php';
        
        $this->conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['name']);
        
        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
        
        
        $this->conn->set_charset("utf8mb4");
    }

    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    
    public function getConnection() {
        return $this->conn;
    }
}