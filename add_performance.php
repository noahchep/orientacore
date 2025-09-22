<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = '';

// Fetch students for dropdown
try {
    $students = $pdo->query("SELECT id, name, reg_no FROM users WHERE role='student' ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id  = $_POST['student_id'] ?? null;
    $course_name = trim($_POST['course_name'] ?? '');
    $semester    = $_POST['semester'] ?? '';
    $percentage  = $_POST['percentage'] ?? null;

    // Validate input
    if (!$student_id || !$course_name || !$semester || $percentage === null) {
        $message = "⚠️ Please fill in all required fields.";
    } elseif (!is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
        $message = "⚠️ Percentage must be between 0 and 100.";
    } else {
        // ✅ Check if student is approved (accept common approved statuses)
        $checkStatus = $pdo->prepare("SELECT status FROM users WHERE id = ?");
        $checkStatus->execute([$student_id]);
        $student = $checkStatus->fetch(PDO::FETCH_ASSOC);

        // Allowed status values — adjust this array if your DB uses a different value
        $allowedStatuses = ['approved', 'active', 'verified', 'enabled', '1', 'true'];

        if (!$student || !in_array(strtolower(trim((string)$student['status'])), $allowedStatuses, true)) {
            $message = "⚠️ This student is not approved to add performance.";
        } else {
            // Generate grade/status
            if ($percentage >= 70) {
                $grade = "First Class";
            } elseif ($percentage >= 60) {
                $grade = "Second Upper";
            } elseif ($percentage >= 50) {
                $grade = "Second Lower";
            } elseif ($percentage >= 40) {
                $grade = "Pass";
            } else {
                $grade = "Fail";
            }

            try {
                // Check if performance already exists for this student + semester
                $check = $pdo->prepare("SELECT COUNT(*) FROM student_performance WHERE student_id = ? AND semester = ?");
                $check->execute([$student_id, $semester]);
                if ($check->fetchColumn() > 0) {
                    $message = "⚠️ Performance for this student in $semester already exists.";
                } else {
                    // Insert performance
                    $stmt = $pdo->prepare("INSERT INTO student_performance (student_id, course_name, semester, gpa, status) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$student_id, $course_name, $semester, $percentage, $grade]);
                    $message = "✅ Performance added successfully!";
                }
            } catch (PDOException $e) {
                $message = "⚠️ Failed to add performance. Please try again.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Student Performance</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; padding: 20px; }
        h1 { font-weight: 600; margin-bottom: 20px; }
        .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        label { display: block; margin-top: 12px; font-weight: 500; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; }
        button { margin-top: 20px; padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
        button:hover { background: #218838; }
        .message { margin-top: 15px; padding: 10px; border-radius: 6px; color: white; font-weight: 500; }
        .success { background: #28a745; }
        .error { background: #dc3545; }
        .back-btn { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>

<a class="back-btn" href="student.php"><i class="fa fa-arrow-left"></i> Back to Students</a>
<h1>Add Student Performance</h1>

<div class="card">
    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'successfully')!==false ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Student</label>
        <select name="student_id" required>
            <option value="">Select Student</option>
            <?php foreach($students as $stu): ?>
                <option value="<?= $stu['id'] ?>"><?= htmlspecialchars($stu['name'] . " (" . $stu['reg_no'] . ")") ?></option>
            <?php endforeach; ?>
        </select>

        <label>Course Name</label>
        <input type="text" name="course_name" required>

        <label>Semester</label>
        <select name="semester" required>
            <option value="">Select Semester</option>
            <option value="Jan-April">Jan-April</option>
            <option value="May-August">May-August</option>
            <option value="September-December">September-December</option>
        </select>

        <label>Percentage</label>
        <input type="number" step="0.01" min="0" max="100" name="percentage" required>

        <button type="submit"><i class="fa fa-plus"></i> Add Performance</button>
    </form>
</div>

</body>
</html>
