<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



define('ROOT_PATH', dirname(__DIR__, 2) . '/');


if (file_exists(ROOT_PATH . 'config/config.php')) {
    require_once ROOT_PATH . 'config/config.php';
}
if (file_exists(ROOT_PATH . 'core/Database.php')) {
    require_once ROOT_PATH . 'core/Database.php'; 
}
if (file_exists(ROOT_PATH . 'core/Auth.php')) {
    require_once ROOT_PATH . 'core/Auth.php';
}


Auth::requireRole('admin');


$db = Database::getInstance()->getConnection();


$totalUsersQuery = $db->query("SELECT COUNT(id) AS total FROM users");
$totalUsers = $totalUsersQuery ? $totalUsersQuery->fetch_assoc()['total'] : 0;


$totalDoctorsQuery = $db->query("SELECT COUNT(id) AS total FROM users WHERE role = 'doctor'");
$totalDoctors = $totalDoctorsQuery ? $totalDoctorsQuery->fetch_assoc()['total'] : 0;


$totalAppointmentsQuery = $db->query("SELECT COUNT(id) AS total FROM appointments");
$totalAppointments = $totalAppointmentsQuery ? $totalAppointmentsQuery->fetch_assoc()['total'] : 0;


if (file_exists(ROOT_PATH . 'views/partials/header.php')) {
    require_once ROOT_PATH . 'views/partials/header.php';
}
if (file_exists(ROOT_PATH . 'views/partials/navbar.php')) {
    require_once ROOT_PATH . 'views/partials/navbar.php';
}
if (file_exists(ROOT_PATH . 'views/partials/sidebar.php')) {
    require_once ROOT_PATH . 'views/partials/sidebar.php';
}
?>

<div class="content-wrapper">
    <div class="content-header py-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark fw-bold">Admin Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            
            <div class="row mb-4">
                
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box bg-white shadow-sm border-0 rounded p-3 mb-3 d-flex align-items-center">
                        <span class="info-box-icon bg-info text-white rounded display-6 px-3 py-2 me-3"><i class="fas fa-users"></i></span>
                        <div class="info-box-content flex-grow-1">
                            <span class="info-box-text text-muted small fw-semibold">Total Users</span>
                            <h3 class="info-box-number m-0 fw-bold text-dark">
                                <?php echo htmlspecialchars($totalUsers, ENT_QUOTES, 'UTF-8'); ?>
                                <small class="text-muted fs-6 d-block fw-normal">Active Accounts</small>
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box bg-white shadow-sm border-0 rounded p-3 mb-3 d-flex align-items-center">
                        <span class="info-box-icon bg-danger text-white rounded display-6 px-3 py-2 me-3"><i class="fas fa-user-md"></i></span>
                        <div class="info-box-content flex-grow-1">
                            <span class="info-box-text text-muted small fw-semibold">Doctors</span>
                            <h3 class="info-box-number m-0 fw-bold text-dark">
                                <?php echo htmlspecialchars($totalDoctors, ENT_QUOTES, 'UTF-8'); ?>
                                <small class="text-muted fs-6 d-block fw-normal">On Duty</small>
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box bg-white shadow-sm border-0 rounded p-3 mb-3 d-flex align-items-center">
                        <span class="info-box-icon bg-success text-white rounded display-6 px-3 py-2 me-3"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content flex-grow-1">
                            <span class="info-box-text text-muted small fw-semibold">Appointments</span>
                            <h3 class="info-box-number m-0 fw-bold text-dark">
                                <?php echo htmlspecialchars($totalAppointments, ENT_QUOTES, 'UTF-8'); ?>
                                <small class="text-muted fs-6 d-block fw-normal">Total Booked</small>
                            </h3>
                        </div>
                    </div>
                </div>
                
            </div>

         <div class="row">
    <div class="col-lg-12">
        <div class="card bg-white shadow-sm border-0 card-outline" style="border-top: 3px solid #007bff;">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 fw-bold text-dark"><i class="fas fa-sliders-h me-2 text-primary"></i>System Control Panel</h5>
            </div>
            <div class="card-body p-4">
                
                <div class="mb-4">
                    <a href="<?= BASE_URL ?>controllers/ReportController.php?action=export" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                        <i class="fas fa-file-excel me-2"></i> Export Appointments Report (CSV)
                    </a>
                </div>

                <hr>
                <div class="mt-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-user-plus text-primary me-2"></i>Add New Patient</h6>
                    <form action="<?= BASE_URL ?>controllers/UserController.php?action=add_patient" method="POST" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control" placeholder="Patient Name" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Save Patient</button>
                        </div>
                    </form>
                </div>
                <p class="card-text text-secondary lh-lg mt-4">
                    Welcome to the administrator central terminal...
                </p>
            </div>
        </div>
    </div>
</div>
            
        </div>
    </div>
</div>

<?php 
if (file_exists(ROOT_PATH . 'views/partials/footer.php')) {
    require_once ROOT_PATH . 'views/partials/footer.php'; 
}
?>