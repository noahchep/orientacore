<?php
session_start();
require 'db.php';

// Only admin can access
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
   // header("Location: login.php");
   // exit;
//}

$student_id = $_GET['student_id'] ?? null;
if (!$student_id) {
    header("Location: student.php");
    exit;
}

// Fetch student info
$stmt = $pdo->prepare("SELECT name, reg_no FROM users WHERE id = ? AND role='student'");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "<p>Student not found. <a href='students.php'>Back</a></p>";
    exit;
}

// Handle Add Performance
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $gpa = $_POST['gpa'] ?? '';
    $status = $_POST['status'] ?? '';

    if ($course_name && $semester && $gpa && $status) {
        $stmt = $pdo->prepare("INSERT INTO student_performance 
            (student_id, course_name, semester, gpa, status, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$student_id, $course_name, $semester, $gpa, $status]);

        $message = "Performance record added successfully!";
    } else {
        $message = "All fields are required.";
    }
}

// Fetch performance records
$stmt = $pdo->prepare("SELECT sp.id, sp.course_name, sp.semester, sp.gpa, sp.status, u.reg_no, u.name 
                       FROM student_performance sp
                       JOIN users u ON sp.student_id = u.id
                       WHERE sp.student_id = ?");
$stmt->execute([$student_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($student['name']) ?> - Performance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; padding: 20px; }
        h1 { font-weight: 600; margin-bottom: 20px; }
        .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .back-btn { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-btn:hover { text-decoration: underline; }
        table { border-collapse: collapse; width: 100%; min-width: 700px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #e0e0e0; text-align: left; }
        th { background-color: #f8f9fa; font-weight: 600; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f3f5; transition: 0.2s; }
        .tag { padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; color: white; }
        .tag-first { background: #28a745; }
        .tag-second-upper { background: #20c997; }
        .tag-second-lower { background: #ffc107; }
        .tag-pass { background: #17a2b8; }
        .tag-fail { background: #dc3545; }
        form { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        form input, form select { padding: 10px; border: 1px solid #ccc; border-radius: 6px; width: 100%; }
        form button { grid-column: span 2; padding: 10px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; }
        form button:hover { background: #0056b3; }
        .message { margin-bottom: 15px; color: green; font-weight: bold; }
    </style>
</head>
<body>

<a class="back-btn" href="student.php"><i class="fa fa-arrow-left"></i> Back to Students</a>
<h1><?= htmlspecialchars($student['name']) ?> - Performance</h1>


<div class="card">
    <h2>Performance Records</h2>
    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Name</th>
                <th>Course</th>
                <th>Semester</th>
                <th>GPA</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($records): ?>
                <?php foreach($records as $rec): ?>
                    <?php
                        $statusClass = match($rec['status']) {
                            'First Class' => 'tag-first',
                            'Second Upper' => 'tag-second-upper',
                            'Second Lower' => 'tag-second-lower',
                            'Pass' => 'tag-pass',
                            'Fail' => 'tag-fail',
                            default => ''
                        };
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($rec['reg_no']) ?></td>
                        <td><?= htmlspecialchars($rec['name']) ?></td>
                        <td><?= htmlspecialchars($rec['course_name']) ?></td>
                        <td><?= htmlspecialchars($rec['semester']) ?></td>
                        <td><?= htmlspecialchars($rec['gpa']) ?></td>
                        <td><span class="tag <?= $statusClass ?>"><?= htmlspecialchars($rec['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No performance records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<a href="add_performance.php">Add Performance</a></li> <!-- new link -->
</body>
</html>
