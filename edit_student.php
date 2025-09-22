<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = '';

// Get student ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$student_id = $_GET['id'];

// Fetch student data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND role = 'student'");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        header("Location: students.php");
        exit;
    }
} catch (PDOException $e) {
    die("Error fetching student: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_no = trim($_POST['reg_no']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $status = $_POST['status'];

    if (empty($reg_no) || empty($name) || empty($email)) {
        $message = "Please fill in all required fields.";
    } else {
        try {
            // Check for duplicate reg_no or email (excluding current student)
            $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE (email = ? OR reg_no = ?) AND id != ?");
            $check->execute([$email, $reg_no, $student_id]);

            if ($check->fetchColumn() > 0) {
                $message = "Email or Registration Number already exists!";
            } else {
                $stmt = $pdo->prepare("UPDATE users SET reg_no = ?, name = ?, email = ?, status = ? WHERE id = ?");
                $stmt->execute([$reg_no, $name, $email, $status, $student_id]);
                $message = "Student updated successfully!";
                // Refresh student data
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$student_id]);
                $student = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        h1 { margin-bottom: 20px; font-weight: 600; }
        .breadcrumb { margin-bottom: 20px; font-size: 14px; color: #555; }
        .breadcrumb span:last-child { font-weight: 600; color: #000; }
        .form-container { max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 12px; font-weight: 500; }
        input, select { padding: 10px; width: 100%; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        button { margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; }
        button:hover { background: #0069d9; }
        .message { margin-top: 15px; padding: 10px; border-radius: 6px; color: white; font-weight: 500; }
        .error { background: #dc3545; }
        .success { background: #28a745; }
        .back-btn { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: 500; }
        .back-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="breadcrumb">
        <span>Dashboard</span> &gt; <span>Edit Student</span>
    </div>

    <div class="form-container">
        <a class="back-btn" href="student.php"><i class="fa fa-arrow-left"></i> Back to Student List</a>
        <h1>Edit Student</h1>

        <?php if ($message): ?>
            <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Registration Number</label>
            <input type="text" name="reg_no" value="<?= htmlspecialchars($student['reg_no']) ?>" required>

            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>

            <label>Status</label>
            <select name="status">
                <option value="active" <?= $student['status']=='active'?'selected':'' ?>>Active</option>
                <option value="inactive" <?= $student['status']=='inactive'?'selected':'' ?>>Inactive</option>
            </select>

            <button type="submit"><i class="fa fa-save"></i> Update Student</button>
        </form>
    </div>
</body>
</html>
