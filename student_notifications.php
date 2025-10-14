<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

// Fetch notifications for this student
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? AND user_type = 'student' ORDER BY created_at DESC");
$stmt->execute([$student_id]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Notifications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4 text-center">My Notifications</h3>

    <?php if (count($notifications) > 0): ?>
        <div class="list-group">
            <?php foreach ($notifications as $note): ?>
                <div class="list-group-item d-flex justify-content-between align-items-start 
                    <?php echo $note['is_read'] ? '' : 'list-group-item-warning'; ?>">
                    <div>
                        <p class="mb-1"><?php echo htmlspecialchars($note['message']); ?></p>
                        <small class="text-muted">
                            <?php echo date('M d, Y h:i A', strtotime($note['created_at'])); ?>
                        </small>
                    </div>
                    <?php if (!$note['is_read']): ?>
                        <form action="mark_notification_read.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
                            <button class="btn btn-sm btn-outline-success">Mark as Read</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No notifications yet.</div>
    <?php endif; ?>
</div>
</body>
</html>
