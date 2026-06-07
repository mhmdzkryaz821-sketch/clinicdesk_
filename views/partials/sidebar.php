<?php

require_once __DIR__ . '/../../config/config.php';
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo BASE_URL; ?>views/dashboard/admin.php" class="brand-link">
        <span class="brand-text font-weight-light">ClinicDesk System</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <?php if (Auth::user('user_role') === 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/dashboard/admin.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/users/index.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/doctors/index.php" class="nav-link">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Manage Doctors</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::user('user_role') === 'doctor'): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/dashboard/doctor.php" class="nav-link">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>My Schedule</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/appointments/manage.php" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Manage Appointments</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::user('user_role') === 'patient'): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/dashboard/patient.php" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>My Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/appointments/book.php" class="nav-link">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Book Appointment</p>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item mt-4">
                    <a href="<?= BASE_URL ?>views/auth/logout.php" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>