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

$categories = ["Interests", "Personality", "Skills", "Work Preference"];

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
<title>Admin - Career Questions</title>
<style>
/* Reset & Typography */
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    background: #f0f2f5;
    color: #2c3e50;
}

/* Container */
.container {
    max-width: 950px;
    margin: 50px auto;
    padding: 0 20px;
}

/* Card Layout */
.card {
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.card:hover { transform: translateY(-5px); }

/* Card Header */
.card h2 {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #1f3b70;
    position: relative;
}
.card h2::after {
    content: '';
    display: block;
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg,#3a86ff,#00bcd4);
    margin: 8px auto 0;
    border-radius: 2px;
}

/* Messages */
.success, .error {
    padding: 14px 18px;
    border-radius: 8px;
    font-size: 15px;
    margin-bottom: 25px;
    font-weight: 500;
}
.success {
    background: #e6f4ea; color: #2f7a32; border: 1px solid #a3d9a5;
}
.error {
    background: #fdecea; color: #a42a2a; border: 1px solid #f1a2a2;
}

/* Form */
form { display: flex; flex-direction: column; gap: 25px; }

label { font-weight: 600; margin-bottom: 6px; display: block; font-size: 15px; }

textarea {
    width: 100%; padding: 18px; border-radius: 12px; border: 1px solid #ccc;
    font-size: 14px; min-height: 180px; resize: vertical;
    transition: all 0.3s;
}
textarea:focus { border-color: #3a86ff; box-shadow: 0 0 8px rgba(58,134,255,0.3); outline: none; }

select {
    width: 100%; padding: 14px; border-radius: 10px; border: 1px solid #ccc;
    font-size: 14px; transition: all 0.3s;
}
select:focus { border-color: #3a86ff; box-shadow: 0 0 8px rgba(58,134,255,0.3); outline: none; }

/* Buttons */
button, .button-link {
    padding: 14px 26px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s;
}
button {
    background: linear-gradient(90deg,#3a86ff,#00bcd4);
    color: white;
}
button:hover { transform: translateY(-2px); opacity: 0.95; }

.button-link {
    background: linear-gradient(90deg,#ff6f61,#ff8a5b);
    color: white;
}
.button-link:hover { transform: translateY(-2px); opacity: 0.95; }

/* Button Group */
.button-group {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 25px;
}

/* Inline Error */
.inline-error { color: #d9534f; font-size: 13px; margin-top: 5px; display: none; }

/* Instructions */
p small code { background: #f0f0f0; padding: 4px 8px; border-radius: 4px; font-size: 13px; }
</style>
<script>
function autoExpand(el){ el.style.height="auto"; el.style.height=(el.scrollHeight)+"px"; }
document.addEventListener("DOMContentLoaded", function(){
    const textarea=document.querySelector("textarea");
    if(textarea){ textarea.addEventListener("input", function(){ autoExpand(this); validateLines(this); }); }
});
function validateLines(textarea){
    const lines=textarea.value.split("\n"); const errorDiv=document.getElementById("lineError"); let invalidLines=[];
    lines.forEach((line,index)=>{ if(line.trim()==="") return; if(line.split("|").length!==5) invalidLines.push(index+1); });
    if(invalidLines.length>0){ errorDiv.textContent="⚠ Invalid format on line(s): "+invalidLines.join(", "); errorDiv.style.display="block"; }
    else{ errorDiv.style.display="none"; }
}
function confirmSubmit(){
    const textarea=document.querySelector("textarea");
    const lines=textarea.value.split("\n").filter(l=>l.trim()!=="");
    const invalid=lines.filter(l=>l.split("|").length!==5);
    if(invalid.length>0){ alert("Please fix the formatting errors before submitting."); return false; }
    return confirm("Are you sure you want to add these questions?");
}
</script>
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Bulk Add Career Questions</h2>

        <?php if($success) echo "<div class='success'>$success</div>"; ?>
        <?php if($error) echo "<div class='error'>$error</div>"; ?>

        <form method="post" onsubmit="return confirmSubmit();">
            <p><small>Format: <code>Question|Option A|Option B|Option C|Option D</code></small></p>
            <textarea name="bulk_questions" placeholder="Example:
Which activities interest you most?|Solving puzzles|Helping people|Designing things|Working outdoors
How do you usually handle problems?|Analyze them logically|Talk to others|Experiment with solutions|Think creatively"></textarea>
            <div id="lineError" class="inline-error"></div>

            <div>
                <label>Select Category:</label>
                <select name="bulk_category" required>
                    <option value="">-- Select Category --</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?=htmlspecialchars($cat)?>"><?=htmlspecialchars($cat)?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="add_bulk">➕ Add Questions</button>
        </form>

        <div class="button-group">
            <a href="admin_career_suggestions.php" class="button-link">📚 Career Test Library</a>
            <a href="admin_manage_questions.php" class="button-link">📝 Manage Questions</a>
        </div>
    </div>
</div>
</body>
</html>
