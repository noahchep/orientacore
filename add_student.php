<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_no = trim($_POST['reg_no']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $status = 'active'; // default status
    $role = 'student';  // always student

    if (empty($reg_no) || empty($name) || empty($email) || empty($password)) {
        $message = "Please fill in all required fields.";
    } else {
        try {
            $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR reg_no = ?");
            $check->execute([$email, $reg_no]);
            if ($check->fetchColumn() > 0) {
                $message = "Email or Registration Number already exists!";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (reg_no, name, email, password_hash, role, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$reg_no, $name, $email, $password_hash, $role, $status]);
                $message = "Student added successfully!";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        h1 { margin-bottom: 20px; font-weight: 600; }
        .breadcrumb { margin-bottom: 20px; font-size: 14px; color: #555; }
        .breadcrumb span:last-child { font-weight: 600; color: #000; }
        .form-container { max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 12px; font-weight: 500; }
        input { padding: 10px; width: 100%; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        button { margin-top: 20px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; }
        button:hover { background: #218838; }
        .message { margin-top: 15px; padding: 10px; border-radius: 6px; color: white; font-weight: 500; }
        .error { background: #dc3545; }
        .success { background: #28a745; }
        .back-btn { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: 500; }
        .back-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="breadcrumb">
        <span>Dashboard</span> &gt; <span>Add Student</span>
    </div>

    <div class="form-container">
        <a class="back-btn" href="student.php"><i class="fa fa-arrow-left"></i> Back to Student List</a>
        <h1>Add New Student</h1>

        <?php if ($message): ?>
            <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Registration Number</label>
            <input type="text" name="reg_no" required>

            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit"><i class="fa fa-plus"></i> Add Student</button>
        </form>
    </div>
</body>
</html>
