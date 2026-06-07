<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/Database.php';


Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();


$sql = "SELECT users.name, users.email, specializations.name AS spec_name, users.status 
        FROM doctors 
        JOIN users ON doctors.user_id = users.id 
        JOIN specializations ON doctors.specialization_id = specializations.id";
$result = $db->query($sql);
$doctors = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Doctors</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Doctor</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php require_once __DIR__ . '/../partials/alerts.php'; ?>
<div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="doctorSearch" class="form-control" placeholder="🔍 Search doctors by name..." onkeyup="filterDoctors()">
    </div>
</div>
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Doctors Directory</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover m-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Specialization</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($doctors)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No doctors registered yet. Click "Add New Doctor" to populate.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($doctors as $doc): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($doc['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($doc['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($doc['spec_name'] ?? 'General', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $doc['status'] === 'active' ? 'success' : 'danger'; ?>">
                                                <?php echo ucfirst($doc['status']); ?>
                                            </span>
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
<script>
function filterDoctors() {
    
    let input = document.getElementById("doctorSearch");
    let filter = input.value.toLowerCase();
    
  
    let table = document.querySelector("table tbody");
    let tr = table.getElementsByTagName("tr");

    
    for (let i = 0; i < tr.length; i++) {
        let nameTd = tr[i].getElementsByTagName("td")[0]; 
        if (nameTd) {
            let txtValue = nameTd.textContent || nameTd.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
<?php 
require_once __DIR__ . '/../partials/footer.php'; 
?>