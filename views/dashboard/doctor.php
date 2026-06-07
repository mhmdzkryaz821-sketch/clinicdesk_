<?php
// views/dashboard/doctor.php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../partials/header.php'; 

Auth::requireRole('doctor');
$db = Database::getInstance()->getConnection();

$doctor_id = Auth::user('user_id'); 
$sql = "SELECT a.*, u.name as patient_name 
        FROM appointments a 
        JOIN users u ON a.patient_id = u.id 
        WHERE a.doctor_id = ? 
        ORDER BY a.appt_date ASC";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-4">
        <h2>Patient Appointments Management</h2>
        <a href="<?= BASE_URL ?>views/auth/login.php" class="btn btn-warning">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <?php if (empty($appointments)): ?>
                <div class="text-center py-5">
                    <p class="text-muted">No appointments found yet.</p>
                </div>
            <?php else: ?>
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                   <tbody>
    <?php foreach ($appointments as $appt): ?>
	
        <tr>
            <td class="font-weight-bold"><?= htmlspecialchars($appt['patient_name']) ?></td>
            <td><?= htmlspecialchars($appt['appt_date']) ?></td>
            <td><?= htmlspecialchars($appt['appt_time']) ?></td>
            <td>
                <?php
                    $status = strtolower($appt['status']);
                    $statusClass = 'badge-secondary';
                    if ($status == 'confirmed') { $statusClass = 'badge-success'; }
                    elseif ($status == 'canceled' || $status == 'cancelled') { $statusClass = 'badge-danger'; }
                    elseif ($status == 'pending') { $statusClass = 'badge-warning'; }
                ?>
                <span class="badge <?= $statusClass ?>">
                    <?= ucfirst($appt['status']) ?>
                </span>
            </td>
            <td>
                <a href="<?= BASE_URL ?>controllers/AppointmentController.php?action=update&id=<?= $appt['id'] ?>&status=confirmed" class="btn btn-sm btn-success">Confirm</a>
                <a href="<?= BASE_URL ?>controllers/AppointmentController.php?action=update&id=<?= $appt['id'] ?>&status=canceled" class="btn btn-sm btn-danger">Cancel</a>
                
                <?php if ($status === 'confirmed' || $status === 'completed'): ?>
                    <hr>
                   <form id="uploadForm_<?= $appt['id'] ?>" class="upload-form" enctype="multipart/form-data">
    <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
    <input type="file" name="prescription_file" required>
    <button type="button" onclick="uploadFile(<?= $appt['id'] ?>)" class="btn btn-sm btn-primary">Upload</button>
</form>
<div id="status_<?= $appt['id'] ?>"></div>

                <?php endif; ?>
            </td>
			
        </tr>
    <?php endforeach; ?>
	<script>
function uploadFile(apptId) {
    var form = document.getElementById('uploadForm_' + apptId);
    var formData = new FormData(form);
    var statusDiv = document.getElementById('status_' + apptId);
    
    statusDiv.innerHTML = "Uploading in progress...";

    fetch('<?= BASE_URL ?>controllers/PrescriptionController.php?action=upload', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
       
       statusDiv.innerHTML = "<a href='<?= BASE_URL ?>uploads/prescriptions/" + data + "' target='_blank' class='text-success font-weight-bold'>View prescription</a>";
    })
    .catch(error => {
        statusDiv.innerHTML = "<span class='text-danger'>An error occurred!</span>";
    });
}
</script>
</tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>