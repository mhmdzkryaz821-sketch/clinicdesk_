<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/Database.php';


Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();


$sql = "SELECT 
            a.id, 
            a.appt_date, 
            a.appt_time, 
            a.status,
            p.name AS patient_name,
            u_doc.name AS doctor_name
        FROM appointments a
        JOIN users p ON a.patient_id = p.id
        JOIN users u_doc ON a.doctor_id = u_doc.id
        ORDER BY a.appt_date DESC, a.appt_time DESC";

$result = $db->query($sql);
$appointments = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Manage Appointments</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Booked Appointments List</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover m-0">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($appointments)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No appointments booked yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($appointments as $app): ?>
                                    <tr>
                                        <td>#<?php echo $app['id']; ?></td>
                                        <td><?php echo htmlspecialchars($app['patient_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>Dr. <?php echo htmlspecialchars($app['doctor_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        
                                        <td>
                                            <i class="far fa-calendar-alt text-muted me-1"></i>
                                            <?php echo htmlspecialchars($app['appt_date'], ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        
                                        <td>
                                            <i class="far fa-clock text-muted me-1"></i>
                                            <?php echo date('h:i A', strtotime($app['appt_time'])); ?>
                                        </td>
                                        
                                        <td>
                                            <?php if ($app['status'] === 'pending'): ?>
                                                <span class="badge bg-warning text-dark px-2 py-1 rounded-pill"><?php echo ucfirst($app['status']); ?></span>
                                            <?php elseif ($app['status'] === 'confirmed'): ?>
                                                <span class="badge bg-success text-white px-2 py-1 rounded-pill"><?php echo ucfirst($app['status']); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary text-white px-2 py-1 rounded-pill"><?php echo ucfirst($app['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>