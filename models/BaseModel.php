<?php

require_once __DIR__ . '/../core/Database.php';

abstract class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * الدالة المركزية المطلوبة لحماية كل الموديلات وعمل Prepared Statements مدمجة
     */
    protected function execute($sql, $types = null, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("SQL Prepare Error: " . $this->db->error);
        }
        if ($types && !empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }
}