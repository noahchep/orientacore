<?php
session_start();
require 'db.php';

// Only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Most common results
$sql = "SELECT result, COUNT(*) AS total FROM career_assessment GROUP BY result ORDER BY total DESC";
$results = $pdo->query($sql)->fetchAll();

// Assessment type breakdown
$sql2 = "SELECT assessment_type, COUNT(*) AS total FROM career_assessment GROUP BY assessment_type ORDER BY total DESC";
$types = $pdo->query($sql2)->fetchAll();
?>

<h2>Career Assessment Reports</h2>

<h3>Most Common Results</h3>
<table border="1">
    <tr><th>Result</th><th>Total</th></tr>
    <?php foreach ($results as $r): ?>
    <tr>
        <td><?= htmlspecialchars($r['result']) ?></td>
        <td><?= $r['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Assessment Types</h3>
<table border="1">
    <tr><th>Assessment Type</th><th>Total Taken</th></tr>
    <?php foreach ($types as $t): ?>
    <tr>
        <td><?= htmlspecialchars($t['assessment_type']) ?></td>
        <td><?= $t['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
