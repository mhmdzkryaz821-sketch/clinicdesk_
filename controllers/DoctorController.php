<?php


require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../core/Database.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);


Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    if (!isset($_POST['csrf_token']) || !CSRF::verifyToken($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    $db = Database::getInstance()->getConnection();

    
    $name = trim($_POST['name']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $specialization_id = (int)$_POST['specialization_id'];
    $consultation_fee = (float)$_POST['consultation_fee'];
    $bio = trim($_POST['bio'] ?? '');

   
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    
    $db->begin_transaction();

    try {
        
        $stmtUser = $db->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'doctor', 'active')");
        $stmtUser->bind_param("sss", $name, $email, $hashed_password);
        $stmtUser->execute();
        
        
        $user_id = $db->insert_id;

        
        $stmtDoc = $db->prepare("INSERT INTO doctors (user_id, specialization_id, consultation_fee, bio) VALUES (?, ?, ?, ?)");
        $stmtDoc->bind_param("iids", $user_id, $specialization_id, $consultation_fee, $bio);
        $stmtDoc->execute();

        
        $db->commit();

        
        header("Location: " . BASE_URL . "views/doctors/index.php");
        exit();

    } catch (Exception $e) {
        
        $db->rollback();
        die("Error saving doctor profile: " . $e->getMessage());
    }
} else {
    
    header("Location: " . BASE_URL . "views/dashboard/admin.php");
    exit();
}