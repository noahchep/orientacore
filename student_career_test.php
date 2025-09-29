<?php
session_start();
require 'db.php';

// Only students
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all questions
$stmt = $pdo->query("SELECT * FROM career_questions ORDER BY id ASC");
$questions = $stmt->fetchAll();

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $responses = $_POST['responses'] ?? [];
    $assessment_type = "career_test";

    // Store as JSON
    $responses_json = json_encode($responses);

    // Example scoring logic: count how many per category
    $score = count($responses);
    $result = "Pending Analysis"; // You can implement logic later

    $insert = $pdo->prepare("INSERT INTO career_assessment (user_id, assessment_type, responses, score, result, created_at) 
                             VALUES (?, ?, ?, ?, ?, NOW())");
    $insert->execute([$user_id, $assessment_type, $responses_json, $score, $result]);

    header("Location: student_dashboard.php?msg=assessment_submitted");
    exit;
}
?>

<h2>Career Assessment</h2>
<form method="post">
    <?php foreach ($questions as $q): ?>
        <div>
            <label><strong><?= htmlspecialchars($q['question_text']) ?></strong></label><br>
            <input type="radio" name="responses[<?= $q['id'] ?>]" value="Yes" required> Yes
            <input type="radio" name="responses[<?= $q['id'] ?>]" value="No" required> No
        </div>
        <hr>
    <?php endforeach; ?>

    <button type="submit">Submit Assessment</button>
</form>
