<?php


require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

$db = Database::getInstance()->getConnection();


$db->query("SET FOREIGN_KEY_CHECKS = 0;");
$db->query("TRUNCATE TABLE `users`;");
$db->query("SET FOREIGN_KEY_CHECKS = 1;");


$name = 'System Admin';
$email = 'admin@clinic.local';
$password = 'Admin@1234';
$role = 'admin';
$status = 'active';

$hashed_password = password_hash($password, PASSWORD_BCRYPT);


$sql = "INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $hashed_password, $role, $status);

if ($stmt->execute()) {
    echo "<div style='padding: 20px; background: #d4edda; color: #155724; font-family: sans-serif; border-radius: 5px; margin: 20px auto; max-width: 60px; text-align: center;'>";
    echo "<h3>Success!</h3>";
    echo "<p>Admin account has been created successfully via PHP.</p>";
    echo "<p><b>Email:</b> admin@clinic.local</p>";
    echo "<p><b>Password:</b> Admin@1234</p>";
    echo "<a href='views/auth/login.php' style='display: inline-block; padding: 10px 20px; background: #28a745; color: #fff; text-decoration: none; border-radius: 3px; margin-top: 10px;'>Go to Login Page</a>";
    echo "</div>";
} else {
    echo "Error creating admin account: " . $db->error;
}