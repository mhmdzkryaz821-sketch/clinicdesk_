<?php

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}


function redirect($path) {
    header('Location: ' . BASE_URL . $path);
    exit();
}


function display_alerts() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="icon fas fa-check"></i> ' . e($_SESSION['success']) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="icon fas fa-ban"></i> ' . e($_SESSION['error']) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['error']);
    }
}


function dd($value) {
    echo "<pre style='background: #111; color: #0f0; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
    var_dump($value);
    echo "</pre>";
    die();
}