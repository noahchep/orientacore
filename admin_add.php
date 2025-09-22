<?php
require 'db.php'; // make sure this is your PDO connection

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (reg_no, name, email, password_hash, role, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute(['ADM001', 'Super Admin', 'admin@example.com', $hash, 'admin', 'active']);

echo "Admin inserted successfully!";
