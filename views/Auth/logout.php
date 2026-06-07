<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../core/Auth.php';


Auth::logout();


header('Location: ' . BASE_URL . 'views/auth/login.php');
exit();