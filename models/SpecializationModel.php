<?php

require_once __DIR__ . '/../core/Database.php';

class SpecializationModel {
    private $db;

    public function __construct() {
        
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM specializations ORDER BY name ASC";
        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}