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

// Fetch distinct categories from career_questions table for dropdown
$categories_stmt = $pdo->query("SELECT DISTINCT category FROM career_questions ORDER BY category ASC");
$categories = $categories_stmt->fetchAll(PDO::FETCH_COLUMN);

// Handle bulk submission
if (isset($_POST['add_bulk'])) {
    $bulk = trim($_POST['bulk_suggestions']);
    $category = $_POST['category'] ?? null;

    if (!$category) {
        $error = "Please select a category.";
    } elseif (empty($bulk)) {
        $error = "Please enter at least one suggestion.";
    } else {
        $lines = array_filter(array_map('trim', explode("\n", $bulk)));
        $stmt = $pdo->prepare("INSERT INTO career_suggestions (category, suggestion, created_at) VALUES (?, ?, NOW())");
        $added = 0;

        foreach ($lines as $line) {
            if (!empty($line)) {
                try {
                    $stmt->execute([$category, $line]);
                    $added++;
                } catch (PDOException $e) {
                    // Skip duplicates or errors
                    continue;
                }
            }
        }
        $success = "✅ Added $added suggestion(s) to category '$category'.";
    }
}
?>

<h2>Bulk Career Suggestions</h2>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label>Select Category:</label><br>
    <select name="category" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Enter Suggestions (one per line):</label><br>
    <textarea name="bulk_suggestions" rows="10" cols="60" placeholder="Example:
Graphic Designer
Writer / Author
Animator / Illustrator
Fashion Designer"></textarea>
    <br><br>

    <button type="submit" name="add_bulk">Add Suggestions</button>
</form>
