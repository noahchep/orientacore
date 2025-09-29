<?php
session_start();
require 'db.php';

// Only admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch all assessments
$stmt = $pdo->query("
    SELECT a.id, a.user_id, a.assessment_type, a.result, a.created_at, u.name, u.reg_no
    FROM career_assessments a
    JOIN users u ON a.user_id = u.id
    ORDER BY a.created_at DESC
");
$assessments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>All Student Assessments</h2>

<?php if (!$assessments): ?>
    <p>No assessments found.</p>
<?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Registration No</th>
            <th>Assessment Type</th>
            <th>Result</th>
            <th>Date Taken</th>
            <th>Action</th>
        </tr>
        <?php foreach ($assessments as $index => $a): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($a['name']) ?></td>
                <td><?= htmlspecialchars($a['reg_no']) ?></td>
                <td><?= htmlspecialchars($a['assessment_type']) ?></td>
                <td><?= htmlspecialchars($a['result']) ?></td>
                <td><?= htmlspecialchars($a['created_at']) ?></td>
                <td>
                    <a href="Response.php?id=<?= $a['id'] ?>">View Response</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
