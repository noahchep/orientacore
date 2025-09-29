<?php
session_start();
require 'db.php';

// Only admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch question by ID
if (!isset($_GET['id'])) {
    header("Location: admin_career_library.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM career_questions WHERE id = ?");
$stmt->execute([$id]);
$question = $stmt->fetch();

if (!$question) {
    die("Question not found.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_question'])) {
    $text = trim($_POST['question_text']);
    $category = trim($_POST['category']);

    $update = $pdo->prepare("UPDATE career_questions SET question_text = ?, category = ? WHERE id = ?");
    $update->execute([$text, $category, $id]);

    header("Location: admin_career_library.php?msg=updated");
    exit;
}
?>

<h2>Edit Question</h2>
<form method="post">
    <textarea name="question_text" required><?= htmlspecialchars($question['question_text']) ?></textarea><br>
    <input type="text" name="category" value="<?= htmlspecialchars($question['category']) ?>" required><br>
    <button type="submit" name="update_question">Update</button>
</form>
