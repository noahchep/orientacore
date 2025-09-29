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

// Define allowed categories
$categories = ["Creative", "Analytical", "Social", "Practical"];

if (isset($_POST['add_bulk'])) {
    $bulk = trim($_POST['bulk_questions']);
    $category = $_POST['bulk_category'] ?? null;

    if (!$category || !in_array($category, $categories)) {
        $error = "⚠ Please select a valid category.";
    } elseif (empty($bulk)) {
        $error = "⚠ Bulk questions cannot be empty.";
    } else {
        $lines = array_filter(array_map('trim', explode("\n", $bulk)));
        $stmt = $pdo->prepare("INSERT INTO career_questions 
            (question_text, option_a, option_b, option_c, option_d, category, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())");
        try {
            $pdo->beginTransaction();
            foreach ($lines as $line) {
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bulk Career Questions (Admin)</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f7f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        padding-top: 40px;
    }

    .container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        max-width: 800px;
        width: 90%;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .success {
        color: #155724;
        background-color: #d4edda;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #c3e6cb;
    }

    .error {
        color: #721c24;
        background-color: #f8d7da;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #f5c6cb;
    }

    textarea {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        resize: vertical;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    textarea:focus {
        border-color: #4CAF50;
        outline: none;
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        margin-top: 5px;
        transition: border-color 0.3s;
    }

    select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #45a049;
        transform: scale(1.02);
    }

    a.back-btn {
        display: inline-block;
        text-decoration: none;
        background: #007BFF;
        color: white;
        padding: 10px 16px;
        border-radius: 6px;
        margin-top: 20px;
    }

    a.back-btn:hover {
        background-color: #0056b3;
    }

    p small {
        color: #555;
        display: block;
        margin-bottom: 5px;
    }

    .inline-error {
        color: #d9534f;
        font-size: 13px;
        margin-top: 5px;
        display: none;
    }

</style>
<script>
    // Auto-expand textarea
    function autoExpand(el) {
        el.style.height = "auto";
        el.style.height = (el.scrollHeight) + "px";
    }

    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.querySelector("textarea");
        textarea.addEventListener("input", function() {
            autoExpand(this);
            validateLines(this);
        });
    });

    // Validate line format in real-time
    function validateLines(textarea) {
        const lines = textarea.value.split("\n");
        const errorDiv = document.getElementById("lineError");
        let invalidLines = [];

        lines.forEach((line, index) => {
            if (line.trim() === "") return; 
            const parts = line.split("|");
            if (parts.length !== 5) invalidLines.push(index + 1);
        });

        if (invalidLines.length > 0) {
            errorDiv.textContent = "⚠ Invalid format on line(s): " + invalidLines.join(", ");
            errorDiv.style.display = "block";
        } else {
            errorDiv.style.display = "none";
        }
    }

    // Confirm submission
    function confirmSubmit() {
        const textarea = document.querySelector("textarea");
        const lines = textarea.value.split("\n").filter(l => l.trim() !== "");
        const invalid = lines.filter(l => l.split("|").length !== 5);

        if (invalid.length > 0) {
            alert("Please fix the formatting errors before submitting.");
            return false;
        }

        return confirm("Are you sure you want to add these questions?");
    }
</script>
</head>
<body>

<div class="container">

    <h2>Bulk Career Questions (Admin)</h2>

    <?php if ($success) echo "<div class='success'>$success</div>"; ?>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>

    <form method="post" onsubmit="return confirmSubmit();">
        <p><small>Format: <code>Question|Option A|Option B|Option C|Option D</code></small></p>
        <textarea name="bulk_questions" rows="10" placeholder="Example:
What do you enjoy most?|Building things|Solving problems|Helping people|Being creative
Which task do you prefer?|Fixing machines|Analyzing data|Counseling others|Designing art"></textarea>
        <div id="lineError" class="inline-error"></div>
        <br><br>

        <label>Select Category for All Questions:</label>
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
        <a href="admin_career_suggestions.php" class="back-btn">← Back to Career Test Library</a>
    </p>

</div>
</body>
</html>
