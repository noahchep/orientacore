<?php
// assessment_test.php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch questions
$stmt = $pdo->query("SELECT * FROM career_questions ORDER BY id ASC");
$questions = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $responses = $_POST['responses'] ?? [];
    $assessment_type = "career_interest";
    $responses_json = json_encode($responses);

    $stmt = $pdo->prepare("INSERT INTO career_assessments 
        (user_id, assessment_type, responses, score, result, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $assessment_type, $responses_json, 0, 'Pending Analysis']);

    header("Location: student_dashboard.php?msg=assessment_submitted");
    exit;
}
?>

<h2>Career Interest Assessment</h2>
<form method="post">
    <?php foreach ($questions as $index => $q): ?>
        <div>
            <p><strong>Q<?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></strong></p>

            <label>
                <input type="radio" name="responses[<?= $q['id'] ?>]" value="A" required>
                <?= htmlspecialchars($q['option_a']) ?>
            </label><br>

            <label>
                <input type="radio" name="responses[<?= $q['id'] ?>]" value="B">
                <?= htmlspecialchars($q['option_b']) ?>
            </label><br>

            <label>
                <input type="radio" name="responses[<?= $q['id'] ?>]" value="C">
                <?= htmlspecialchars($q['option_c']) ?>
            </label><br>

            <label>
                <input type="radio" name="responses[<?= $q['id'] ?>]" value="D">
                <?= htmlspecialchars($q['option_d']) ?>
            </label>
        </div>
        <hr>
    <?php endforeach; ?>

    <button type="submit">Submit Assessment</button>
</form>
