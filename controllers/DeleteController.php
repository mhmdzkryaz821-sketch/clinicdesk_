<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Database.php';


Auth::requireRole('admin');

if (isset($_GET['type']) && isset($_GET['id'])) {
    $db = Database::getInstance()->getConnection();
    $type = $_GET['type'];
    $id = (int)$_GET['id'];

    if ($type === 'user' || $type === 'doctor') {
      
        $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        
        if ($type === 'doctor') {
            header("Location: " . BASE_URL . "views/doctors/index.php");
        } else {
            header("Location: " . BASE_URL . "views/users/index.php");
        }
        exit();
    }
}


header("Location: " . BASE_URL . "views/dashboard/admin.php");
exit();