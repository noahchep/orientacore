<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['category'])) {
    header("Location: behavior.php");
    exit;
}

$userId = $_SESSION['user_id'];
$category = $_POST['category'];

// Fetch all questions for the selected category
$stmt = $pdo->prepare("SELECT * FROM behavior_questions WHERE category = ? ORDER BY id ASC");
$stmt->execute([$category]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($questions)) {
    echo "<script>alert('No questions found for this category.'); window.location='behavior.php';</script>";
    exit;
}

// Map POST responses to numeric scores
$scoreMapping = [
    'A' => 5, // Strongly agree
    'B' => 4, // Agree
    'C' => 2, // Disagree
    'D' => 1  // Strongly disagree
];

// Delete previous responses for this user & category to avoid duplicates
$questionIds = array_column($questions, 'id');
$placeholders = implode(',', array_fill(0, count($questionIds), '?'));
$deleteStmt = $pdo->prepare("DELETE FROM behavior_responses WHERE user_id = ? AND question_id IN ($placeholders)");
$deleteStmt->execute(array_merge([$userId], $questionIds));

// Insert new responses
foreach ($questions as $q) {
    $qid = $q['id'];
    $answer = $_POST['q'.$qid] ?? null;
    if ($answer && isset($scoreMapping[$answer])) {
        $score = $scoreMapping[$answer];
        $insertStmt = $pdo->prepare("INSERT INTO behavior_responses (user_id, question_id, score) VALUES (?, ?, ?)");
        $insertStmt->execute([$userId, $qid, $score]);
    }
}

// Optional: Calculate average score for the category
$stmt = $pdo->prepare("SELECT AVG(score) as avg_score FROM behavior_responses WHERE user_id = ? AND question_id IN ($placeholders)");
$stmt->execute(array_merge([$userId], $questionIds));
$avgScore = round($stmt->fetchColumn(), 2);

// Determine behavior interpretation (simple example)
$behaviorType = match (true) {
    $avgScore >= 4.5 => 'Excellent',
    $avgScore >= 3.5 => 'Good',
    $avgScore >= 2.5 => 'Average',
    default => 'Needs Improvement'
};

// Redirect back with a success message and behavior type
echo "<script>
        alert('Behavior assessment submitted successfully!\\nCategory: $category\\nScore: $avgScore\\nEvaluation: $behaviorType');
        window.location='behavior.php';
      </script>";
exit;
