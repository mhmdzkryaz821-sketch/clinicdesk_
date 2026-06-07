<?php


require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Auth.php';

class DashboardController {

    public function index() {
        
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . 'views/auth/login.php');
            exit();
        }

        $role = Auth::user('user_role');
        
        
        switch ($role) {
            case 'admin':
                header('Location: ' . BASE_URL . 'views/dashboard/admin.php');
                break;
            case 'doctor':
                header('Location: ' . BASE_URL . 'views/dashboard/doctor.php');
                break;
            case 'patient':
                header('Location: ' . BASE_URL . 'views/dashboard/patient.php');
                break;
            default:
                Auth::logout();
                break;
        }
        exit();
    }
}


$dashboard = new DashboardController();
$dashboard->index();