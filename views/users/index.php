<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/Database.php';


Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();


$sql = "SELECT id, name, email, role, status FROM users ORDER BY id DESC";
$result = $db->query($sql);
$users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/sidebar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Users</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
		<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="userSearch" class="form-control" placeholder="🔍 Search users by name or email..." onkeyup="filterUsers()">
    </div>
</div>
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">System Users Accounts</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover m-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width: 150px;">Actions</th> </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No users found in the system.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>#<?php echo $user['id']; ?></td>
                                        <td><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <?php if ($user['role'] === 'admin'): ?>
                                                <span class="badge badge-primary">Admin</span>
                                            <?php elseif ($user['role'] === 'doctor'): ?>
                                                <span class="badge badge-info">Doctor</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Patient</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                                                <?php echo ucfirst($user['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($user['role'] !== 'admin'): ?>
                                                <?php $deleteType = ($user['role'] === 'doctor') ? 'doctor' : 'user'; ?>
                                                
                                                <a href="<?php echo BASE_URL; ?>controllers/DeleteController.php?type=<?php echo $deleteType; ?>&id=<?php echo $user['id']; ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            <?php else: ?>
                                                <span class="badge badge-light text-muted">Core Admin</span>
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
<script>
function filterUsers() {
    let input = document.getElementById("userSearch");
    let filter = input.value.toLowerCase();
    let table = document.querySelector("table tbody");
    let tr = table.getElementsByTagName("tr");

    for (let i = 0; i < tr.length; i++) {
       
        let nameTd = tr[i].getElementsByTagName("td")[1];
        let emailTd = tr[i].getElementsByTagName("td")[2];
        
        if (nameTd || emailTd) {
            let nameText = nameTd.textContent || nameTd.innerText;
            let emailText = emailTd.textContent || emailTd.innerText;
            
            
            if (nameText.toLowerCase().indexOf(filter) > -1 || emailText.toLowerCase().indexOf(filter) > -1) {
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