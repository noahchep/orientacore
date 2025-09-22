<?php
// delete_session.php
require 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Session ID not provided.");
}

$session_id = intval($_GET['id']);

// Fetch session details
$stmt = $pdo->prepare("SELECT student_id FROM sessions WHERE id = ?");
$stmt->execute([$session_id]);
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session) {
    die("Session not found.");
}

// Delete session
$stmt = $pdo->prepare("DELETE FROM sessions WHERE id = ?");
$stmt->execute([$session_id]);

header("Location: sessions.php?student_id=" . $session['student_id']);
exit;
?>
