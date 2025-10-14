<?php
session_start();
require 'db.php'; // must create $pdo in this file

// Basic safety: make sure $pdo exists
if (!isset($pdo) || !$pdo instanceof PDO) {
    // replace this with better error handling in production
    die("Database connection not found. Check db.php (should create \$pdo PDO instance).");
}

// Ensure counsellor is logged in and role is counsellor
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'counsellor') {
    header("Location: login.php");
    exit;
}

$counsellor_id = $_SESSION['user_id'];

// Always initialize $sessions as an array so count() is safe
$sessions = [];

// Handle approve/decline POST (if any)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['session_id'], $_POST['action'])) {
    $session_id = intval($_POST['session_id']);
    $action = $_POST['action']; // expected: "approved" or "declined"

    if (!in_array($action, ['approved', 'declined'])) {
        // invalid action — ignore or show error
        $_SESSION['msg'] = "Invalid action.";
        header("Location: counsellor_view_sessions.php");
        exit;
    }

    try {
        // Update session status
        $stmt = $pdo->prepare("UPDATE sessions SET status = ?, updated_at = NOW() WHERE id = ? AND counsellor_id = ?");
        $stmt->execute([$action, $session_id, $counsellor_id]);

        // Check that a row was updated (optional)
        if ($stmt->rowCount() > 0) {
            // Fetch session info for notifications
            $stmt2 = $pdo->prepare("
                SELECT s.student_id, u.name AS student_name
                FROM sessions s
                JOIN users u ON s.student_id = u.id
                WHERE s.id = ?
            ");
            $stmt2->execute([$session_id]);
            $sess = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($sess) {
                $student_id = $sess['student_id'];
                $student_msg = "Your counselling session request has been " . ucfirst($action) . " by the counsellor.";

                // Insert notification for student
                $ins = $pdo->prepare("INSERT INTO notifications (user_id, user_type, message) VALUES (?, 'student', ?)");
                $ins->execute([$student_id, $student_msg]);

                // Notify all admins
                $admin_msg = "A counselling session for student (ID {$student_id}) has been {$action}.";
                $admins = $pdo->query("SELECT id FROM users WHERE role = 'admin'")->fetchAll(PDO::FETCH_ASSOC);
                $insAdmin = $pdo->prepare("INSERT INTO notifications (user_id, user_type, message) VALUES (?, 'admin', ?)");
                foreach ($admins as $admin) {
                    $insAdmin->execute([$admin['id'], $admin_msg]);
                }
            }
            $_SESSION['msg'] = "Session {$action} successfully.";
        } else {
            // No row updated — either session doesn't exist or belongs to another counsellor
            $_SESSION['msg'] = "No session updated. Check that this session exists and is assigned to you.";
        }

    } catch (PDOException $e) {
        // log the error and show a friendly message (don't reveal sensitive info in production)
        error_log("DB error (update_session): " . $e->getMessage());
        $_SESSION['msg'] = "Database error while updating session.";
    }

    // Redirect to avoid form resubmission
    header("Location: counsellor_view_sessions.php");
    exit;
}

// Fetch sessions assigned to this counsellor
try {
    $stmt = $pdo->prepare("
        SELECT s.*, u.name AS student_name, u.email AS student_email
        FROM sessions s
        JOIN users u ON s.student_id = u.id
        WHERE s.counsellor_id = ?
        ORDER BY s.created_at DESC
    ");
    $stmt->execute([$counsellor_id]);
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!is_array($sessions)) {
        $sessions = [];
    }
} catch (PDOException $e) {
    error_log("DB error (fetch sessions): " . $e->getMessage());
    $sessions = [];
    $_SESSION['msg'] = "Could not load sessions. Try again later.";
}

// Grab message (if any)
$msg = '';
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Counselling Sessions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background:#f7f9fc; }
        table { width:100%; border-collapse: collapse; background:#fff; box-shadow:0 0 6px rgba(0,0,0,0.06);}
        th, td { padding:10px; border-bottom:1px solid #eee; text-align:left; }
        th { background:#007bff; color:#fff; }
        .status-pending { color:orange; font-weight:bold; }
        .status-approved { color:green; font-weight:bold; }
        .status-declined { color:red; font-weight:bold; }
        .action-btn { border:none; padding:8px 12px; border-radius:5px; color:#fff; cursor:pointer; margin-right:6px; }
        .approve-btn { background:#28a745; }
        .decline-btn { background:#dc3545; }
        .msg { padding:10px; background:#e9f7ef; border:1px solid #cdebd7; color:#1b5e20; margin-bottom:12px; border-radius:4px; }
    </style>
</head>
<body>

    <h2>My Counselling Sessions</h2>

    <?php if ($msg): ?>
        <div class="msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Date</th>
                <th>Mode</th>
                <th>Notes</th>
                <th>Action Plan</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($sessions) > 0): ?>
                <?php foreach ($sessions as $session): 
                    $status = strtolower(trim($session['status'] ?? 'pending'));
                    $status_class = 'status-' . ($status === 'approved' ? 'approved' : ($status === 'declined' ? 'declined' : 'pending'));
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($session['student_name'] ?? 'Unknown') ?></td>
                        <td><?= htmlspecialchars($session['session_date'] ?? '') ?></td>
                        <td><?= htmlspecialchars($session['mode'] ?? '') ?></td>
                        <td><?= nl2br(htmlspecialchars($session['notes'] ?? '')) ?></td>
                        <td><?= nl2br(htmlspecialchars($session['action_plan'] ?? '')) ?></td>
                        <td class="<?= $status_class ?>"><?= ucfirst($status) ?></td>
                        <td>
                            <?php if ($status === 'pending'): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="session_id" value="<?= intval($session['id'] ?? 0) ?>">
                                    <input type="hidden" name="action" value="approved">
                                    <button type="submit" class="action-btn approve-btn">Approve</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="session_id" value="<?= intval($session['id'] ?? 0) ?>">
                                    <input type="hidden" name="action" value="declined">
                                    <button type="submit" class="action-btn decline-btn">Decline</button>
                                </form>
                            <?php else: ?>
                                <em>No further action</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7"><em>No sessions assigned to you yet.</em></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
