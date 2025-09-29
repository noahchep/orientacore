<?php
session_start();
require 'db.php';

// Only admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("DELETE FROM career_questions WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: admin_career_library.php?msg=deleted");
    exit;
}
?>
