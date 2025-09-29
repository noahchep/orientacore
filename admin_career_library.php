<?php
// admin_career_library.php
session_start();
require 'db.php';

// Only admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$success = "";

// --- Single Question Form ---
if (isset($_POST['add_single'])) {
    $question_text = trim($_POST['question_text']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $category  = $_POST['category'] ?? null;

    if ($question_text && $option_a && $option_b && $option_c && $option_d) {
        $stmt = $pdo->prepare("INSERT INTO career_questions 
            (question_text, option_a, option_b, option_c, option_d, category, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$question_text, $option_a, $option_b, $option_c, $option_d, $category]);
        $success = "✅ Question added successfully!";
    }
}

// --- Bulk Questions Form ---
if (isset($_POST['add_bulk'])) {
    $bulk = trim($_POST['bulk_questions']);
    $category = $_POST['bulk_category'] ?? null;

    if (!empty($bulk)) {
        $lines = explode("\n", $bulk);
        $stmt = $pdo->prepare("INSERT INTO career_questions 
            (question_text, option_a, option_b, option_c, option_d, category, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())");

        foreach ($lines as $line) {
            // Ignore empty lines
            if (trim($line) === '') continue;

            // Format: Question|Option A|Option B|Option C|Option D
            $parts = array_map('trim', explode("|", $line));

            if (count($parts) === 5) {
                [$q, $a, $b, $c, $d] = $parts;
                $stmt->execute([$q, $a, $b, $c, $d, $category]);
            } else {
                // Debugging: log malformed lines
                error_log("❌ Skipped line (wrong format): " . $line);
            }
        }
        $success = "✅ Bulk questions added successfully!";
    }
}
?>

<h2>Career Test Library (Admin)</h2>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<!-- Single Question Form -->
<h3>Add Single Question</h3>
<form method="post">
    <label>Question:</label><br>
    <textarea name="question_text" required></textarea><br><br>

    <label>Option A:</label><br>
    <input type="text" name="option_a" required><br><br>

    <label>Option B:</label><br>
    <input type="text" name="option_b" required><br><br>

    <label>Option C:</label><br>
    <input type="text" name="option_c" required><br><br>

    <label>Option D:</label><br>
    <input type="text" name="option_d" required><br><br>

    <label>Category (optional, e.g., Realistic/Artistic):</label><br>
    <input type="text" name="category"><br><br>

    <button type="submit" name="add_single">Add Question</button>
</form>

<hr>

<!-- Bulk Questions Form -->
<h3>Add Bulk Questions</h3>
<p><small>Format: <code>Question|Option A|Option B|Option C|Option D</code><br>
One question per line.</small></p>
<form method="post">
    <textarea name="bulk_questions" rows="10" cols="80" placeholder="Example:
What do you enjoy most?|Building things|Solving problems|Helping people|Being creative
What’s your favorite task?|Fixing machines|Analyzing data|Counseling others|Designing art"></textarea>
    <br><br>
    <label>Category (optional for all):</label><br>
    <input type="text" name="bulk_category"><br><br>
    <button type="submit" name="add_bulk">Add Bulk Questions</button>
</form>
