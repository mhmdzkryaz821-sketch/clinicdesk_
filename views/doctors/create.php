<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
require_once __DIR__ . '/../../models/SpecializationModel.php';

Auth::requireRole('admin');

$specModel = new SpecializationModel();
$specializations = $specModel->getAll();

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Register New Doctor</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header"><h3 class="card-title">Doctor Account & Profile</h3></div>
                <form action="<?php echo BASE_URL; ?>controllers/DoctorController.php" method="POST">
                    <?php CSRF::outputField(); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Dr. Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="email@clinicdesk.com" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Specialization</label>
                            <select name="specialization_id" class="form-control" required>
                                <option value="">-- Select Specialization --</option>
                                <?php foreach ($specializations as $spec): ?>
                                    <option value="<?php echo $spec['id']; ?>"><?php echo $spec['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Consultation Fee ($)</label>
                            <input type="number" step="0.01" name="consultation_fee" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Brief Bio</label>
                            <textarea name="bio" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Doctor Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>