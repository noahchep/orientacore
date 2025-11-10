<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Define behavior categories
$behaviorCategories = [
    "Leadership & Responsibility",
    "Creativity & Innovation",
    "Teamwork & Collaboration",
    "Communication Skills",
    "Problem Solving & Critical Thinking",
    "Adaptability & Flexibility",
    "Work Ethic & Motivation",
    "Emotional Intelligence & Empathy",
    "Organization & Time Management",
    "Self-Confidence & Initiative"
];

// Get selected category from GET (or show selection if none)
$selectedCategory = $_GET['category'] ?? null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
    $userId = $_SESSION['user_id'];
    $category = $_POST['category'];

    // Loop through POSTed responses
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'q') === 0) { // Only keys starting with q are questions
            $questionId = (int)substr($key, 1);
            $score = match ($value) {
                'A' => 5,
                'B' => 4,
                'C' => 2,
                'D' => 1,
                default => 0
            };

            // Insert response into behavior_responses table
            $stmt = $pdo->prepare("INSERT INTO behavior_responses (user_id, question_id, score, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$userId, $questionId, $score]);
        }
    }

    // Redirect directly to behavior report
    header("Location: behavior_report.php");
    exit;
}

// Fetch questions from database if category selected
$questions = [];
if ($selectedCategory) {
    $stmt = $pdo->prepare("SELECT * FROM behavior_questions WHERE category = ? ORDER BY id ASC");
    $stmt->execute([$selectedCategory]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Behavior Assessment</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
body { font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; padding: 0; text-align: center; }
.container { width: 90%; max-width: 900px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px; }
h1, h2 { color: #007bff; }
fieldset { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 25px; text-align: left; }
label { display: block; margin-left: 20px; cursor: pointer; }
.submit-btn, button { display: block; width: 100%; background: #007bff; color: #fff; font-weight: 600; border: none; border-radius: 8px; padding: 12px; cursor: pointer; transition: background 0.3s; margin-top: 15px; }
.submit-btn:hover, button:hover { background: #0056b3; }
select { padding: 10px; font-size: 16px; margin-top: 20px; width: 100%; border-radius: 8px; border: 1px solid #ccc; }
a.career-link { color: #007bff; font-weight: 600; text-decoration: none; }
a.career-link:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h1>Take Behavior Assessment</h1>

    <!-- Link back to Career Assessment -->
    <p>Or take the <a href="career.php" class="career-link">Career Assessment</a></p>

    <?php if (!$selectedCategory): ?>
        <!-- Show behavior category selection -->
        <p>Please select a behavior category to start your assessment:</p>
        <form method="GET">
            <select name="category" required>
                <option value="">-- Select Behavior Category --</option>
                <?php foreach ($behaviorCategories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Start Assessment</button>
        </form>

    <?php elseif (empty($questions)): ?>
        <p>No questions available for this category yet. Please check back later.</p>

    <?php else: ?>
        <!-- Display questions from database -->
        <form method="POST">
            <input type="hidden" name="category" value="<?= htmlspecialchars($selectedCategory) ?>">

            <?php foreach ($questions as $q): ?>
                <fieldset>
                    <legend><?= htmlspecialchars($q['question_text']) ?></legend>
                    <label><input type="radio" name="q<?= $q['id'] ?>" value="A" required> <?= htmlspecialchars($q['option_a']) ?></label>
                    <label><input type="radio" name="q<?= $q['id'] ?>" value="B"> <?= htmlspecialchars($q['option_b']) ?></label>
                    <label><input type="radio" name="q<?= $q['id'] ?>" value="C"> <?= htmlspecialchars($q['option_c']) ?></label>
                    <label><input type="radio" name="q<?= $q['id'] ?>" value="D"> <?= htmlspecialchars($q['option_d']) ?></label>
                </fieldset>
            <?php endforeach; ?>

            <button type="submit" class="submit-btn">Submit Assessment</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
