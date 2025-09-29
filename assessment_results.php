<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$assessment_id = $_GET['id'] ?? null;

if (!$assessment_id) {
    die("Invalid request.");
}

// Fetch the assessment
$stmt = $pdo->prepare("SELECT * FROM career_assessments WHERE id = ? AND user_id = ?");
$stmt->execute([$assessment_id, $user_id]);
$assessment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$assessment) {
    die("Assessment not found.");
}

// Decode JSON
$responses = json_decode($assessment['responses'], true) ?: [];

// Tally categories
$category_count = [];
foreach ($responses as $resp) {
    $cat = $resp['category'] ?? 'General';
    $category_count[$cat] = ($category_count[$cat] ?? 0) + 1;
}

// Top category
arsort($category_count);
$top_category = array_key_first($category_count);

// Fetch suggestions from career_suggestions table for the top category
$suggestions = [];
if ($top_category) {
    $stmt = $pdo->prepare("SELECT suggestion FROM career_suggestions WHERE category = ?");
    $stmt->execute([$top_category]);
    $suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<h2>Career Assessment Results</h2>
<p><strong>Date Taken:</strong> <?= htmlspecialchars($assessment['created_at']) ?></p>

<h3>Your Answers</h3>
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

<h3>Suggested Career Paths</h3>
<?php if (!empty($suggestions)): ?>
    <ul>
        <?php foreach ($suggestions as $s): ?>
            <li><?= htmlspecialchars($s) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No career suggestions available yet for this category.</p>
<?php endif; ?>
