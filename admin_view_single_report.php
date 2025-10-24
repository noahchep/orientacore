<?php
require 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get report ID
$report_id = $_GET['report_id'] ?? null;

if (!$report_id) {
    die("No report selected.");
}

// Fetch report
$stmt = $pdo->prepare("SELECT * FROM counselor_reports WHERE id = ?");
$stmt->execute([$report_id]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    die("Report not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Counseling Report</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f8f9fa;
            margin: 30px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header img {
            width: 70px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #007BFF;
            margin: 0;
        }
        .report-box {
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: auto;
        }
        h2 {
            color: #007BFF;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        p {
            margin: 6px 0;
            line-height: 1.6;
        }
        .label {
            font-weight: bold;
        }
        .print-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .print-btn:hover {
            background: #0056b3;
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
    <h1>Counseling Session Report</h1>
    <p><em>Administrator View - Official Record</em></p>
</div>

<div class="report-box">
    <h2>Student Information</h2>
    <p><span class="label">Student Name:</span> <?= htmlspecialchars($report['student_name']); ?></p>
    <p><span class="label">Session Date:</span> <?= htmlspecialchars($report['session_date']); ?></p>
    <p><span class="label">Session Topic:</span> <?= htmlspecialchars($report['session_topic']); ?></p>
    <p><span class="label">Next Session:</span> <?= htmlspecialchars($report['next_session']); ?></p>
    <p><span class="label">Created On:</span> <?= htmlspecialchars($report['created_at']); ?></p>

    <h2>Session Details</h2>
    <p><span class="label">Issues Discussed:</span><br><?= nl2br(htmlspecialchars($report['issues_discussed'])); ?></p>
    <p><span class="label">Counselor Remarks:</span><br><?= nl2br(htmlspecialchars($report['counselor_remarks'])); ?></p>
    <p><span class="label">Recommendations:</span><br><?= nl2br(htmlspecialchars($report['recommendations'])); ?></p>

    <button class="print-btn" onclick="window.print()">🖨 Print / Save as PDF</button>
    <br>
    <a href="admin_view_reports.php?student_name=<?= urlencode($report['student_name']) ?>" class="back-link">← Back to Reports List</a>
</div>

</body>
</html>
