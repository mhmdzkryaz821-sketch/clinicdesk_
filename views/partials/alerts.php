<?php



if (function_exists('display_alerts')) {
    display_alerts();
} else {
  
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                ' . htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                ' . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['error']);
    }
}