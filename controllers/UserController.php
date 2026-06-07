<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

class UserController {

    
    public function add_patient() {
        Auth::requireRole('admin'); 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'patient')");
            $stmt->bind_param("sss", $name, $email, $password);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Patient added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add patient.";
            }
            
            header('Location: ' . BASE_URL . 'views/dashboard/admin.php');
            exit();
        }
    }
    // ---------------------------------
}


$action = $_GET['action'] ?? '';
$controller = new UserController();

if ($action === 'add_patient') {
    $controller->add_patient();
}