<?php
session_start();
require 'db.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get student id
$student_id = $_GET['student_id'] ?? null;

if (!$student_id) {
    die("No student selected. Please go back and select a student.");
}

// ✅ Fetch latest assessment for this student
$stmt = $pdo->prepare("SELECT * FROM career_assessments WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$student_id]);
$assessment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$assessment) {
    die("No assessment found for this student.");
}

// ✅ Fetch student info
$stmt = $pdo->prepare("SELECT id, name, reg_no, email FROM users WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Decode responses
$responses = json_decode($assessment['responses'], true) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Assessment Responses</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header img {
            width: 70px;
            height: auto;
            margin-bottom: 10px;
        }
        h1 {
            margin: 0;
            color: #007BFF;
        }
        .student-info {
            margin-bottom: 25px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .student-info p {
            margin: 5px 0;
        }
        ul {
            margin: 0;
            padding-left: 20px;
        }
        .responses {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .responses li {
            margin-bottom: 12px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .print-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .print-btn:hover {
            background: #0056b3;
        }
        @media print {
            .print-btn, .back-link {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="logo.JPG" alt="System Logo">
        <h1>Student Assessment Responses</h1>
        <p><em>Detailed report of student answers</em></p>
    </div>

    <div class="student-info">
        <p><strong>Name:</strong> <?= htmlspecialchars($student['name'] ?? 'Unknown') ?></p>
        <p><strong>Reg No:</strong> <?= htmlspecialchars($student['reg_no'] ?? '-') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($student['email'] ?? '-') ?></p>
        <p><strong>Date Taken:</strong> <?= htmlspecialchars($assessment['created_at']) ?></p>
        <p><strong>Assessment Type:</strong> <?= htmlspecialchars($assessment['assessment_type']) ?></p>
        <p><strong>Result:</strong> <?= htmlspecialchars($assessment['result']) ?></p>
    </div>

    <div class="responses">
        <h2>Student Answers</h2>
        <ul>
            <?php if (!empty($responses)): ?>
                <?php foreach ($responses as $resp): ?>
                    <li>
                        <strong><?= htmlspecialchars($resp['question'] ?? 'Question') ?></strong><br>
                        Answer: <?= htmlspecialchars($resp['answer'] ?? '-') ?>
                        <?php if (!empty($resp['text'])): ?>
                            - <?= htmlspecialchars($resp['text']) ?>
                        <?php endif; ?>
                        (Category: <?= htmlspecialchars($resp['category'] ?? 'General') ?>)
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No responses found for this assessment.</p>
            <?php endif; ?>
        </ul>
    </div>

    <button class="print-btn" onclick="window.print()">🖨 Print / Save as PDF</button>
    <br>
    <a href="student.php" class="back-link">← Back to Assessments</a>

</body>
</html>
