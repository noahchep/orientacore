<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Define available categories
$categories = ["Interests", "Personality", "Skills", "Work Preference"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select Assessment Category</title>
<style>
body { font-family: Arial, sans-serif; background: #f8f9fa; text-align: center; padding: 50px; }
select, button { padding: 10px; font-size: 16px; margin-top: 20px; }
</style>
</head>
<body>
<h1>Choose Assessment Category</h1>
<form action="career_assessment.php" method="GET">
    <label for="category">Select a category to begin:</label><br>
    <select name="category" id="category" required>
        <option value="">--Select Category--</option>
        <?php foreach($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Start Assessment</button>
</form>
</body>
</html>
