<?php

require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../partials/header.php'; 

Auth::requireRole('patient');

$db = Database::getInstance()->getConnection();
$patient_id = Auth::user('user_id');


$sql = "SELECT a.*, u.name as doctor_name, p.file_path 
        FROM appointments a 
        JOIN users u ON a.doctor_id = u.id 
        LEFT JOIN prescriptions p ON a.id = p.appointment_id 
        WHERE a.patient_id = ? ORDER BY a.appt_date DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>


<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>My Medical Appointments</h2>
        <a href="<?= BASE_URL ?>views/appointments/book.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Book New Appointment
        </a>
		<a href="<?= BASE_URL ?>controllers/AuthController.php?action=logout" class="btn btn-warning">
    <i class="fas fa-sign-out-alt"></i> Logout & Back to Login
</a>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($appointments)): ?>
                <p>No appointments found. Use the button above to book one.</p>
            <?php else: ?>
			
              <table class="table table-bordered">
			  <?php

?>
    <thead>
        <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Prescription</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appt): ?>
            <tr>
                <td>Dr. <?= htmlspecialchars($appt['doctor_name']) ?></td>
                <td><?= htmlspecialchars($appt['appt_date']) ?></td>
                <td><?= htmlspecialchars($appt['appt_time']) ?></td>
                <td><?= htmlspecialchars($appt['status']) ?></td>
               <td>
    <?php 
    $fileName = $appt['file_path'];
    
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/clinicdesk/uploads/prescriptions/' . $fileName;

   
    if (!empty($fileName) && file_exists($fullPath)): ?>
        <button onclick="checkAndDownload('<?= urlencode($fileName) ?>')" class="btn btn-sm btn-info">
            <i class="fas fa-file-pdf"></i> Download
        </button>
    <?php else: ?>
        <span class="text-muted">No file available</span>
    <?php endif; ?>
</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php require_once __DIR__ . '/../partials/footer.php'; ?>