<?php
session_start();
require 'db.php'; // must create $pdo (PDO instance)

// only students can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}
$student_id = $_SESSION['user_id'];
$errors = [];
$success = '';

// fetch available counsellors (active)
$cStmt = $pdo->prepare("SELECT id, name, email, reg_no FROM users WHERE role = 'counsellor' AND status = 'active' ORDER BY name");
$cStmt->execute();
$counsellors = $cStmt->fetchAll(PDO::FETCH_ASSOC);

// handle POST (booking)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // read + sanitize
    $counsellor_id = intval($_POST['counsellor_id'] ?? 0);
    $session_date_raw = trim($_POST['session_date'] ?? '');
    $mode = trim($_POST['mode'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $action_plan = trim($_POST['action_plan'] ?? '');

    // basic validation
    if ($counsellor_id <= 0) $errors[] = "Please choose a counsellor.";
    if (!$session_date_raw) $errors[] = "Please choose a date and time for the session.";
    // try to parse datetime (expecting "YYYY-MM-DDTHH:MM" from datetime-local)
    $dt = date_create($session_date_raw);
    if (!$dt) $errors[] = "Invalid date/time format.";
    else $session_date = $dt->format('Y-m-d H:i:s');

    if (!$mode) $errors[] = "Please choose a session mode.";

    if (empty($errors)) {
        try {
            // insert session: status pending
            $ins = $pdo->prepare("INSERT INTO sessions (student_id, counsellor_id, session_date, mode, notes, action_plan, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())");
            $ins->execute([$student_id, $counsellor_id, $session_date, $mode, $notes, $action_plan]);
            $session_id = $pdo->lastInsertId();

            // notification for counsellor
            $studentNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
            $studentNameStmt->execute([$student_id]);
            $sRow = $studentNameStmt->fetch(PDO::FETCH_ASSOC);
            $studentName = $sRow['name'] ?? 'A student';

            $counMsg = "New counselling session requested by {$studentName} for " . date('M d, Y h:i A', strtotime($session_date)) . ".";
            $insNotif = $pdo->prepare("INSERT INTO notifications (user_id, user_type, message, is_read, created_at) VALUES (?, 'counsellor', ?, 0, NOW())");
            $insNotif->execute([$counsellor_id, $counMsg]);

            // notify all admins
            $adminMsg = "New counselling session requested by {$studentName} (session ID: {$session_id}).";
            $admins = $pdo->query("SELECT id FROM users WHERE role = 'admin' AND status = 'active'")->fetchAll(PDO::FETCH_ASSOC);
            $insAdmin = $pdo->prepare("INSERT INTO notifications (user_id, user_type, message, is_read, created_at) VALUES (?, 'admin', ?, 0, NOW())");
            foreach ($admins as $a) {
                $insAdmin->execute([$a['id'], $adminMsg]);
            }

            $success = "Session requested successfully. The counsellor and admin have been notified.";
        } catch (PDOException $e) {
            error_log("Error inserting session: " . $e->getMessage());
            $errors[] = "An error occurred while saving your request. Try again later.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Book Counselling Session</title>
  <style>
    body{font-family:Arial;max-width:800px;margin:20px auto;padding:10px;}
    label{display:block;margin-top:10px;font-weight:600}
    input, select, textarea{width:100%;padding:8px;margin-top:6px;border:1px solid #ccc;border-radius:5px}
    .btn{background:#2c7be5;color:#fff;padding:10px 14px;border:none;border-radius:6px;cursor:pointer;margin-top:12px}
    .error{background:#fdecea;color:#611a15;padding:8px;border-radius:6px;margin-bottom:10px}
    .success{background:#e6ffed;color:#063; padding:8px;border-radius:6px;margin-bottom:10px}
  </style>
</head>
<body>
  <h2>Book a Counselling Session</h2>

  <?php if ($errors): ?>
    <div class="error">
      <?php foreach ($errors as $err) echo "<div>" . htmlspecialchars($err) . "</div>"; ?>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <label for="counsellor_id">Choose Counsellor</label>
    <select name="counsellor_id" id="counsellor_id" required>
      <option value="">-- Select Counsellor --</option>
      <?php foreach ($counsellors as $c): ?>
        <option value="<?= $c['id'] ?>" <?= (isset($counsellor_id) && $counsellor_id == $c['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['name'] . " (" . ($c['reg_no'] ?: $c['email']) . ")") ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label for="session_date">Date & Time</label>
    <!-- HTML5 datetime-local input. The browser returns something like "2025-10-14T15:30" -->
    <input type="datetime-local" id="session_date" name="session_date" value="<?= isset($session_date_raw) ? htmlspecialchars($session_date_raw) : '' ?>" required>

    <label for="mode">Mode</label>
    <select name="mode" id="mode" required>
      <option value="">-- Select Mode --</option>
      <option value="Physical" <?= (isset($mode) && $mode === 'Physical') ? 'selected' : '' ?>>Physical</option>
      <option value="Online" <?= (isset($mode) && $mode === 'Online') ? 'selected' : '' ?>>Online</option>
      <option value="Phone" <?= (isset($mode) && $mode === 'Phone') ? 'selected' : '' ?>>Phone</option>
    </select>

    <label for="notes">Notes / Reason for session (optional)</label>
    <textarea id="notes" name="notes" rows="4"><?= htmlspecialchars($notes ?? '') ?></textarea>

    <label for="action_plan">What would you like to achieve? (optional)</label>
    <textarea id="action_plan" name="action_plan" rows="3"><?= htmlspecialchars($action_plan ?? '') ?></textarea>

    <button class="btn" type="submit">Request Session</button>
  </form>
</body>
</html>
