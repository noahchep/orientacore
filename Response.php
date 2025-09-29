<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$assessment_id = $_GET['id'] ?? null;

if (!$assessment_id) {
    die("No assessment selected. Please go back and select an assessment.");
}

// Fetch the assessment
$stmt = $pdo->prepare("SELECT * FROM career_assessments WHERE id = ?");
$stmt->execute([$assessment_id]);
$assessment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$assessment) {
    die("Assessment not found.");
}

// Fetch student info from users table
$stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->execute([$assessment['user_id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Decode student responses
$responses = json_decode($assessment['responses'], true) ?: [];

// Count categories
$category_count = [];
foreach ($responses as $resp) {
    $cat = $resp['category'] ?? 'General';
    $category_count[$cat] = ($category_count[$cat] ?? 0) + 1;
}

// Top category
arsort($category_count);
$top_category = array_key_first($category_count);

// Fetch career suggestions for top category
$suggestions = [];
if ($top_category) {
    $stmt = $pdo->prepare("SELECT suggestion FROM career_suggestions WHERE category = ?");
    $stmt->execute([$top_category]);
    $suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<h2>Assessment Details for <?= htmlspecialchars($student['name'] ?? 'Unknown') ?></h2>
<p><strong>Email:</strong> <?= htmlspecialchars($student['email'] ?? '-') ?></p>
<p><strong>Date Taken:</strong> <?= htmlspecialchars($assessment['created_at']) ?></p>
<p><strong>Assessment Type:</strong> <?= htmlspecialchars($assessment['assessment_type']) ?></p>
<p><strong>Result Status:</strong> <?= htmlspecialchars($assessment['result']) ?></p>

<h3>Student Answers</h3>
<ul>
<?php foreach ($responses as $resp): ?>
    <li>
        <strong><?= htmlspecialchars($resp['question']) ?></strong><br>
        Chosen: <?= htmlspecialchars($resp['answer']) ?> - <?= htmlspecialchars($resp['text']) ?>
        (Category: <?= htmlspecialchars($resp['category'] ?? 'General') ?>)
    </li>
<?php endforeach; ?>
</ul>

<h3>Category Tally</h3>
<ul>
<?php foreach ($category_count as $cat => $count): ?>
    <li><?= htmlspecialchars($cat) ?>: <?= $count ?> answers</li>
<?php endforeach; ?>
</ul>

<h3>Suggested Careers</h3>
<?php if (!empty($suggestions)): ?>
    <ul>
        <?php foreach ($suggestions as $s): ?>
            <li><?= htmlspecialchars($s) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No career suggestions added yet for this category.</p>
<?php endif; ?>

<p><a href="admin_view_assessment.php">← Back to All Assessments</a></p>
