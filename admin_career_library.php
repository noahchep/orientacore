<?php
session_start();
require 'db.php';

// Only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle add question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $question = trim($_POST['question_text']);
    $category = trim($_POST['category']);

    $stmt = $pdo->prepare("INSERT INTO career_questions (question_text, category) VALUES (?, ?)");
    $stmt->execute([$question, $category]);
}

// Fetch questions
$questions = $pdo->query("SELECT * FROM career_questions ORDER BY id DESC")->fetchAll();
?>

<h2>Career Test Library</h2>

<form method="post">
    <textarea name="question_text" placeholder="Enter question" required></textarea><br>
    <input type="text" name="category" placeholder="Category (e.g. IT, Arts)" required><br>
    <button type="submit" name="add_question">Add Question</button>
</form>

<h3>Existing Questions</h3>
<table border="1">
    <tr><th>ID</th><th>Question</th><th>Category</th><th>Action</th></tr>
    <?php foreach ($questions as $q): ?>
    <tr>
        <td><?= $q['id'] ?></td>
        <td><?= htmlspecialchars($q['question_text']) ?></td>
        <td><?= htmlspecialchars($q['category']) ?></td>
        <td>
            <a href="edit_question.php?id=<?= $q['id'] ?>">Edit</a> | 
            <a href="delete_question.php?id=<?= $q['id'] ?>" onclick="return confirm('Delete this question?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
