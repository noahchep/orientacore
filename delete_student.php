<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Check if student ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$student_id = $_GET['id'];
$message = '';

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
            $stmt->execute([$student_id]);
            $message = "Student deleted successfully!";
            // Redirect after short delay
            header("refresh:2;url=students.php");
        } catch (PDOException $e) {
            $message = "Error deleting student: " . $e->getMessage();
        }
    } else {
        // Cancel deletion
        header("Location:student.php");
        exit;
    }
}

// Fetch student info to display name
try {
    $stmt = $pdo->prepare("SELECT name, reg_no FROM users WHERE id = ? AND role = 'student'");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        header("Location: students.php");
        exit;
    }
} catch (PDOException $e) {
    die("Error fetching student: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        h1 { margin-bottom: 20px; font-weight: 600; color: #dc3545; }
        .breadcrumb { margin-bottom: 20px; font-size: 14px; color: #555; }
        .breadcrumb span:last-child { font-weight: 600; color: #000; }
        .card { max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; margin: 10px; color: white; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        .btn-cancel { background: #6c757d; }
        .btn-cancel:hover { background: #5a6268; }
        .message { margin-top: 20px; padding: 10px; border-radius: 6px; font-weight: 500; color: white; background: #28a745; }
        .back-btn { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: 500; }
        .back-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="breadcrumb">
        <span>Dashboard</span> &gt; <span>Delete Student</span>
    </div>

    <div class="card">
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
            <p>Redirecting to student list...</p>
        <?php else: ?>
            <h1><i class="fa fa-exclamation-triangle"></i> Confirm Deletion</h1>
            <p>Are you sure you want to delete <strong><?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['reg_no']) ?>)</strong>?</p>

            <form method="POST" action="">
                <button type="submit" name="confirm" value="yes" class="btn btn-delete"><i class="fa fa-trash"></i> Yes, Delete</button>
                <button type="submit" name="confirm" value="no" class="btn btn-cancel"><i class="fa fa-times"></i> Cancel</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
