<?php

$password = 'password123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "انسخ هذا الـ Hash وضعه في قاعدة البيانات: " . $hashedPassword;
?>