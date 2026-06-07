<?php


class Auth {
    
    
public static function login($user) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role']; 
    $_SESSION['logged_in'] = true;
}

 
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

   
    public static function user($key = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($key === null) return $_SESSION;
        return $_SESSION[$key] ?? null;
    }


    public static function requireRole($allowedRoles) {
        if (!self::check()) {
            header('Location: ' . BASE_URL . 'views/auth/login.php');
            exit();
        }

        $userRole = self::user('user_role');
        
        
        $roles = is_array($allowedRoles) ? $allowedRoles : [$allowedRoles];

        if (!in_array($userRole, $roles)) {
            
            header('Location: ' . BASE_URL . 'views/errors/403.php');
            exit();
        }
    }

    
    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}