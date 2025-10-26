<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Define all available categories (comprehensive career fields)
$categories = [
    "Agriculture & Natural Resources",
    "Architecture & Construction",
    "Arts, Design, Entertainment & Media",
    "Business Management & Administration",
    "Education & Training",
    "Finance & Accounting",
    "Government, Public Administration & Policy",
    "Health Science & Allied Professions",
    "Hospitality & Tourism",
    "Human Services / Community & Social Services",
    "Information Technology & Computer Science",
    "Law, Public Safety, Corrections & Security",
    "Manufacturing & Production",
    "Marketing, Sales & Retail",
    "Science, Technology, Engineering & Mathematics (STEM)",
    "Transportation, Distribution & Logistics",
    "Skilled Trades & Vocational Work",
    "Creative & Performing Arts",
    "Entrepreneurship & Start-ups",
    "Research & Data Analytics"
];

// Get selected category from GET (or show selection if none)
$selectedCategory = $_GET['category'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Career Assessment</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
  font-family: 'Inter', sans-serif;
  background: #f8f9fa;
  margin: 0;
  padding: 0;
  text-align: center;
}
.container {
  width: 90%;
  max-width: 900px;
  margin: 30px auto;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  padding: 30px;
}
h1, h2 { color: #007bff; }
fieldset {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 25px;
  text-align: left;
}
label { display: block; margin-left: 20px; cursor: pointer; }
.submit-btn, button {
  display: block;
  width: 100%;
  background: #007bff;
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  padding: 12px;
  cursor: pointer;
  transition: background 0.3s;
  margin-top: 15px;
}
.submit-btn:hover, button:hover { background: #0056b3; }
select {
  padding: 10px;
  font-size: 16px;
  margin-top: 20px;
  width: 100%;
  border-radius: 8px;
  border: 1px solid #ccc;
}
</style>
</head>
<body>
<div class="container">
    <h1>Career Assessment</h1>

    <?php if (!$selectedCategory): ?>
        <!-- Show category selection -->
        <p>Please select a career category to start your assessment:</p>
        <form method="GET">
            <select name="category" required>
                <option value="">-- Select Career Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Start Assessment</button>
        </form>

    <?php else: ?>
        <!-- Fetch questions for selected category -->
        <?php
        $stmt = $pdo->prepare("SELECT * FROM career_questions WHERE category = ? ORDER BY id");
        $stmt->execute([$selectedCategory]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <p>Please answer all the questions honestly to get accurate results for <strong><?= htmlspecialchars($selectedCategory) ?></strong>.</p>

        <?php if (!empty($questions)): ?>
            <form action="process_assessment.php" method="POST">
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
        <?php else: ?>
            <p>No questions available for this category yet. Please check back later.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
