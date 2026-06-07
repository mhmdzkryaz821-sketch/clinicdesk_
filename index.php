<?php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Auth.php';

if (Auth::check()) {
    
    $role = Auth::user('user_role');
    header('Location: ' . BASE_URL . 'views/dashboard/' . $role . '.php');
} else {
   
    header('Location: ' . BASE_URL . 'views/auth/login.php');
}
exit();