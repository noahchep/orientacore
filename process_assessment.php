<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Get submitted category
$category = $_POST['category'] ?? null;
if (!$category) {
    die("Invalid request: category not selected.");
}

// Fetch questions for the selected category
$stmt = $pdo->prepare("SELECT id FROM career_questions WHERE category = ?");
$stmt->execute([$category]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$questions) {
    die("No questions found for this category.");
}

// Collect student answers
$responses = [];
$totalScore = 0;
foreach ($questions as $q) {
    $qid = $q['id'];
    $answer = $_POST["q$qid"] ?? null;
    if (!$answer) {
        die("Please answer all questions.");
    }

    // Assign numeric value (A=4, B=3, C=2, D=1)
    $score = match ($answer) {
        'A' => 4,
        'B' => 3,
        'C' => 2,
        'D' => 1,
        default => 0,
    };

    $responses[] = [
        'student_id' => $_SESSION['user_id'],
        'question_id' => $qid,
        'selected_option' => $answer,
        'category' => $category
    ];

    $totalScore += $score;
}

// Save responses in student_responses table
$insertStmt = $pdo->prepare("
    INSERT INTO student_responses (student_id, question_id, selected_option, category, created_at)
    VALUES (:student_id, :question_id, :selected_option, :category, NOW())
");

try {
    $pdo->beginTransaction();
    foreach ($responses as $r) {
        $insertStmt->execute($r);
    }

    // Save total score in career_category_scores (update if exists)
    $pdo->prepare("
        INSERT INTO career_category_scores (student_id, category, score, created_at)
        VALUES (:student_id, :category, :score, NOW())
        ON DUPLICATE KEY UPDATE score = :score, created_at = NOW()
    ")->execute([
        'student_id' => $_SESSION['user_id'],
        'category' => $category,
        'score' => $totalScore
    ]);

    // Fetch career recommendation based on score range
    $recommendationStmt = $pdo->prepare("
        SELECT recommended_careers
        FROM career_recommendations
        WHERE category = :category
          AND :score BETWEEN min_score AND max_score
        LIMIT 1
    ");
    $recommendationStmt->execute([
        'category' => $category,
        'score' => $totalScore
    ]);
    $recommendation = $recommendationStmt->fetchColumn();

    // Save recommendation to student_career_results
    if ($recommendation) {
        $pdo->prepare("
            INSERT INTO student_career_results (student_id, category, total_score, recommendation, created_at)
            VALUES (:student_id, :category, :total_score, :recommendation, NOW())
            ON DUPLICATE KEY UPDATE total_score = :total_score, recommendation = :recommendation, created_at = NOW()
        ")->execute([
            'student_id' => $_SESSION['user_id'],
            'category' => $category,
            'total_score' => $totalScore,
            'recommendation' => $recommendation
        ]);
    }

    $pdo->commit();
    header("Location: assessment_results.php?category=" . urlencode($category) . "&success=1");
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    die("Error saving responses: " . $e->getMessage());
}
