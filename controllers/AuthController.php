<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                Auth::login($user);
                $this->redirectToDashboard($user['role']);
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header('Location: ' . BASE_URL . 'views/auth/login.php');
                exit();
            }
        }
    }

    private function redirectToDashboard($role) {
        switch ($role) {
            case 'admin': header('Location: ' . BASE_URL . 'views/dashboard/admin.php'); break;
            case 'doctor': header('Location: ' . BASE_URL . 'views/dashboard/doctor.php'); break;
            case 'patient': header('Location: ' . BASE_URL . 'views/dashboard/patient.php'); break;
            default: Auth::logout(); header('Location: ' . BASE_URL . 'views/auth/login.php');
        }
        exit();
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'views/auth/login.php');
        exit();
    }
}


$controller = new AuthController();
$action = $_GET['action'] ?? '';

if ($action === 'login') {
    $controller->login();
} elseif ($action === 'logout') {
    $controller->logout();
}