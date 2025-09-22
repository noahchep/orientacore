<?php
// edit_session.php
require 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Session ID not provided.");
}

$session_id = intval($_GET['id']);

// Fetch session details
$stmt = $pdo->prepare("SELECT * FROM sessions WHERE id = ?");
$stmt->execute([$session_id]);
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session) {
    die("Session not found.");
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_date = $_POST['session_date'];
    $mode = $_POST['mode'];
    $notes = $_POST['notes'];
    $action_plan = $_POST['action_plan'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE sessions 
                           SET session_date=?, mode=?, notes=?, action_plan=?, status=? 
                           WHERE id=?");
    $stmt->execute([$session_date, $mode, $notes, $action_plan, $status, $session_id]);

    header("Location: sessions.php?student_id=" . $session['student_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning">
            <h5>Edit Session</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="session_date" value="<?= htmlspecialchars($session['session_date']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mode</label>
                    <select name="mode" class="form-select" required>
                        <option value="Physical" <?= $session['mode']=='Physical'?'selected':'' ?>>Physical</option>
                        <option value="Virtual" <?= $session['mode']=='Virtual'?'selected':'' ?>>Virtual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($session['notes']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Action Plan</label>
                    <textarea name="action_plan" class="form-control" rows="3"><?= htmlspecialchars($session['action_plan']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Pending" <?= $session['status']=='Pending'?'selected':'' ?>>Pending</option>
                        <option value="Completed" <?= $session['status']=='Completed'?'selected':'' ?>>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update Session</button>
                <a href="sessions.php?student_id=<?= $session['student_id'] ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
