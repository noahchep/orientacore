<?php
session_start();
require 'db.php'; // make sure this defines $pdo

// Only allow admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ensure we have a question ID
if (!isset($_GET['id'])) {
    header("Location: manage_questions.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch the question
$stmt = $pdo->prepare("SELECT * FROM career_questions WHERE id = ?");
$stmt->execute([$id]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$question) {
    die("Question not found.");
}

// Handle form submission
if (isset($_POST['update_question'])) {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $category = $_POST['category'];

    $update = $pdo->prepare("UPDATE career_questions 
                             SET question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, category=? 
                             WHERE id=?");
    if ($update->execute([$question_text, $option_a, $option_b, $option_c, $option_d, $category, $id])) {
        $msg = "✅ Question updated successfully!";
        $stmt = $pdo->prepare("SELECT * FROM career_questions WHERE id = ?");
        $stmt->execute([$id]);
        $question = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $msg = "❌ Error updating question.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Career Question</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f9;
    margin: 0;
    padding: 40px;
}
.container {
    background-color: #fff;
    max-width: 900px;
    margin: auto;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
}
form label {
    display: block;
    font-weight: 500;
    margin-bottom: 6px;
    font-size: 14px;
}
textarea, input[type="text"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
}
textarea {
    resize: vertical;
}
.row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.col-half {
    flex: 1 1 45%;
}
.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}
button, .btn {
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    color: white;
}
button.primary {
    background-color: #007bff;
}
button.primary:hover {
    background-color: #0069d9;
}
a.btn-secondary {
    background-color: #6c757d;
    display: inline-block;
    text-align: center;
}
a.btn-secondary:hover {
    background-color: #5a6268;
}
.alert {
    padding: 12px 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-size: 14px;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
</head>
<body>
<div class="container">
    <h2>✏️ Edit Career Assessment Question</h2>

    <?php if (!empty($msg)): ?>
        <div class="alert <?php echo strpos($msg,'✅')===0 ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Question Text</label>
        <textarea name="question_text" required><?php echo htmlspecialchars($question['question_text']); ?></textarea>

        <div class="row">
            <div class="col-half">
                <label>Option A</label>
                <input type="text" name="option_a" value="<?php echo htmlspecialchars($question['option_a']); ?>" required>
            </div>
            <div class="col-half">
                <label>Option B</label>
                <input type="text" name="option_b" value="<?php echo htmlspecialchars($question['option_b']); ?>" required>
            </div>
            <div class="col-half">
                <label>Option C</label>
                <input type="text" name="option_c" value="<?php echo htmlspecialchars($question['option_c']); ?>">
            </div>
            <div class="col-half">
                <label>Option D</label>
                <input type="text" name="option_d" value="<?php echo htmlspecialchars($question['option_d']); ?>">
            </div>
        </div>

        <label>Category</label>
        <select name="category" required>
            <option value="">-- Select Category --</option>
            <option value="Interest" <?php if ($question['category']=='Interest') echo 'selected'; ?>>Interest</option>
            <option value="Personality" <?php if ($question['category']=='Personality') echo 'selected'; ?>>Personality</option>
            <option value="Skills" <?php if ($question['category']=='Skills') echo 'selected'; ?>>Skills</option>
            <option value="Work Preference" <?php if ($question['category']=='Work Preference') echo 'selected'; ?>>Work Preference</option>
        </select>

        <div class="button-group">
            <a href="admin_manage_questions.php" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" name="update_question" class="primary">💾 Update Question</button>
        </div>
    </form>
</div>
</body>
</html>
