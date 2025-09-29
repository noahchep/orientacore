<?php
session_start();
require 'db.php';

// Only admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$success = "";
$error = "";

// Define allowed categories (match your table values)
$categories = ["Creative", "Analytical", "Social", "Practical"];

// --- Bulk Questions Form ---
if (isset($_POST['add_bulk'])) {
    $bulk = trim($_POST['bulk_questions']);
    $category = $_POST['bulk_category'] ?? null;

    if (!$category || !in_array($category, $categories)) {
        $error = "⚠ Please select a valid category.";
    } elseif (empty($bulk)) {
        $error = "⚠ Bulk questions cannot be empty.";
    } else {
        $lines = array_filter(array_map('trim', explode("\n", $bulk))); // Remove empty lines
        $stmt = $pdo->prepare("INSERT INTO career_questions 
            (question_text, option_a, option_b, option_c, option_d, category, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())");

        try {
            $pdo->beginTransaction();
            foreach ($lines as $line) {
                // Format: Question|Option A|Option B|Option C|Option D
                $parts = array_map('trim', explode("|", $line));
                if (count($parts) !== 5) {
                    throw new Exception("Invalid format in line: $line");
                }
                [$q, $a, $b, $c, $d] = $parts;
                $stmt->execute([$q, $a, $b, $c, $d, $category]);
            }
            $pdo->commit();
            $success = "✅ Bulk questions added successfully!";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "⚠ Error inserting bulk questions: " . $e->getMessage();
        }
    }
}
?>

<h2>Bulk Career Questions (Admin)</h2>

<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>


<form method="post">
    <p><small>Format: <code>Question|Option A|Option B|Option C|Option D</code></small></p>
    <textarea name="bulk_questions" rows="10" cols="80" placeholder="Example:
What do you enjoy most?|Building things|Solving problems|Helping people|Being creative
Which task do you prefer?|Fixing machines|Analyzing data|Counseling others|Designing art"></textarea>
    <br><br>

    <label>Select Category for All Questions:</label><br>
    <select name="bulk_category" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit" name="add_bulk">Add Bulk Questions</button>
</form>

<p>
    <a href="admin_career_suggestions.php" style="text-decoration:none; background:#4CAF50; color:white; padding:8px 12px; border-radius:5px;">
        ← Back to Career Test Library
    </a>
</p>
