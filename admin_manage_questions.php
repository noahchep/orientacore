<?php
session_start();
require 'db.php'; // make sure this defines $pdo

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM career_questions WHERE id = ?");
        $stmt->execute([$id]);
        $msg = "✅ Question deleted successfully!";
    } catch (PDOException $e) {
        $error = "⚠ Error deleting question: " . $e->getMessage();
    }
}

// Define categories
$categories = ["Interest", "Personality", "Skills", "Work Preference"];

// Handle category filter
$selected_category = $_GET['category'] ?? '';

try {
    if ($selected_category && in_array($selected_category, $categories)) {
        $stmt = $pdo->prepare("SELECT * FROM career_questions WHERE category = ? ORDER BY created_at DESC");
        $stmt->execute([$selected_category]);
    } else {
        $stmt = $pdo->query("SELECT * FROM career_questions ORDER BY created_at DESC");
    }
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching questions: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Career Questions</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f9;
    margin: 0;
    padding: 40px;
}
.container {
    background-color: #fff;
    max-width: 1100px;
    margin: auto;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
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
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
th, td {
    padding: 10px 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
tr:hover {
    background-color: #f9f9f9;
}
select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-bottom: 15px;
}
.action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    font-size: 13px;
    margin-right: 5px;
}
.edit {
    background-color: #007bff;
}
.edit:hover {
    background-color: #0069d9;
}
.delete {
    background-color: #dc3545;
}
.delete:hover {
    background-color: #c82333;
}
.top-bar {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 15px;
}
.btn {
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
}
.btn-add {
    background-color: #28a745;
}
.btn-add:hover {
    background-color: #218838;
}
</style>
</head>
<body>
<div class="container">
    <div class="top-bar">
        <h2>Manage Career Questions</h2>
        <a href="admin_career_library.php" class="btn btn-add">➕ Add New Question</a>
    </div>

    <?php if (!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <?php if (!empty($error)) echo "<div class='alert alert-error'>$error</div>"; ?>

    <form method="get">
        <label>Filter by Category:</label>
        <select name="category" onchange="this.form.submit()">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= $selected_category === $cat ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Options</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $q): ?>
                <tr>
                    <td><?= $q['id'] ?></td>
                    <td><?= htmlspecialchars($q['question_text']) ?></td>
                    <td>
                        A. <?= htmlspecialchars($q['option_a']) ?><br>
                        B. <?= htmlspecialchars($q['option_b']) ?><br>
                        C. <?= htmlspecialchars($q['option_c']) ?><br>
                        D. <?= htmlspecialchars($q['option_d']) ?>
                    </td>
                    <td><?= htmlspecialchars($q['category']) ?></td>
                    <td>
                        <a class="action-btn edit" href="edit_question.php?id=<?= $q['id'] ?>">✏️ Edit</a>
                        <a class="action-btn delete" href="?delete=<?= $q['id'] ?>" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No questions found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <p style="margin-top: 20px;">
        <a href="admin_career_library.php" class="btn btn-add">← Back to Career Library</a>
    </p>
</div>
</body>
</html>
