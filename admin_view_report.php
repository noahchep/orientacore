<?php
require 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get student name from URL
$student_name = $_GET['student_name'] ?? null;

if (!$student_name) {
    die("No student selected.");
}

// Fetch all reports for this student
$stmt = $pdo->prepare("SELECT * FROM counselor_reports WHERE student_name = ? ORDER BY session_date DESC");
$stmt->execute([$student_name]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Student Reports</title>
<style>
body { font-family: "Segoe UI", Arial, sans-serif; background: #f8f9fa; padding: 30px; color: #333; }
.header { text-align: center; margin-bottom: 25px; }
.header img { width: 70px; margin-bottom: 10px; }
.header h1 { color: #007BFF; margin: 0; }
.table-container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { padding: 12px 10px; border: 1px solid #e0e0e0; text-align: left; }
th { background: #007BFF; color: white; }
tr:nth-child(even) { background: #f9f9f9; }
tr:hover { background: #e8f0fe; }
.print-btn { margin-top: 15px; padding: 8px 15px; background: #007BFF; color: white; border: none; border-radius: 6px; cursor: pointer; }
.print-btn:hover { background: #0056b3; }
.back-link { display: inline-block; margin-top: 15px; text-decoration: none; color: #007BFF; font-weight: bold; }
.back-link:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="header">
    <img src="logo.JPG" alt="Logo">
    <h1>Reports for <?= htmlspecialchars($student_name) ?></h1>
</div>

<?php if (count($reports) > 0): ?>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Session Date</th>
                <th>Topic</th>
                <th>Issues Discussed</th>
                <th>Counselor Remarks</th>
                <th>Recommendations</th>
                <th>Next Session</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
            <tr>
                <td><?= htmlspecialchars($report['session_date']) ?></td>
                <td><?= htmlspecialchars($report['session_topic']) ?></td>
                <td><?= nl2br(htmlspecialchars($report['issues_discussed'])) ?></td>
                <td><?= nl2br(htmlspecialchars($report['counselor_remarks'])) ?></td>
                <td><?= nl2br(htmlspecialchars($report['recommendations'])) ?></td>
                <td><?= htmlspecialchars($report['next_session']) ?></td>
                <td>
                    <a href="admin_view_single_report.php?report_id=<?= $report['id'] ?>" class="print-btn">View / Print</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <p>No reports found for this student.</p>
<?php endif; ?>

<a href="students.php" class="back-link">← Back to Students List</a>

</body>
</html>
