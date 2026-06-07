<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
require_once __DIR__ . '/../../core/Database.php';

Auth::requireRole('patient');

$db = Database::getInstance()->getConnection();

$doctorsResult = $db->query("SELECT u.id, u.name, s.name as specialization_name 
                             FROM doctors d 
                             JOIN users u ON d.user_id = u.id 
                             JOIN specializations s ON d.specialization_id = s.id 
                             WHERE u.status = 'active'");
$doctors = $doctorsResult ? $doctorsResult->fetch_all(MYSQLI_ASSOC) : [];

require_once __DIR__ . '/../partials/header.php';
?>

<form action="<?php echo BASE_URL; ?>controllers/AppointmentController.php?action=book" method="POST">
    <?php CSRF::outputField(); ?>
    <div class="card-body">
        <div class="form-group">
            <label>Choose Doctor</label>
            <select name="doctor_id" class="form-control" required>
    <option value="">-- Select Doctor --</option>
    <?php foreach ($doctors as $doc): ?>
        <option value="<?php echo $doc['id']; ?>">
            Dr. <?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?> 
            - [<?php echo htmlspecialchars($doc['specialization_name'], ENT_QUOTES, 'UTF-8'); ?>]
        </option>
    <?php endforeach; ?>
</select>
        </div>
        
        <div class="form-group">
            <label>Appointment Date</label>
            <input type="date" name="appt_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Available Time Slot</label>
            <select name="appt_time" class="form-control" required>
                <option value="">-- Select Time --</option>
                <option value="09:00:00">09:00 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="13:00:00">01:00 PM</option>
                <option value="14:00:00">02:00 PM</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" class="form-control" placeholder="Any special notes?"></textarea>
        </div>
    </div>
    
   <div class="card-footer">
        <button type="submit" class="btn btn-primary">Confirm Booking</button>
        
        <a href="<?php echo BASE_URL; ?>views/dashboard/patient.php" class="btn btn-secondary ml-2">
            Back to Dashboard
        </a>

        <a href="<?php echo BASE_URL; ?>views/dashboard/admin.php" class="btn btn-dark ml-2">
            Admin Dashboard
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>	