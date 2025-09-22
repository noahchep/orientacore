<?php
session_start();
require_once "db.php";

// fetch all sessions with student details
$sql = "SELECT s.id, u.reg_no, u.name, s.session_date, s.mode, s.status
        FROM sessions s
        JOIN users u ON s.student_id = u.id
        ORDER BY s.session_date DESC";
$stmt = $conn->query($sql);
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// fetch all students (for linking to add session)
$students = $conn->query("SELECT id, reg_no, name FROM users WHERE role='student'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Sessions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <h2>Student Sessions</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Reg No</th>
            <th>Name</th>
            <th>Date</th>
            <th>Mode</th>
            <th>Status</th>
        </tr>
        <?php foreach ($sessions as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['reg_no']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['session_date']) ?></td>
            <td><?= htmlspecialchars($row['mode']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Add Session</h3>
    <ul>
        <?php foreach ($students as $st): ?>
            <li>
                <?= htmlspecialchars($st['reg_no']) ?> - <?= htmlspecialchars($st['name']) ?>
                <a href="add_session.php?student_id=<?= $st['id'] ?>"><i class="fa fa-plus"></i> Add Session</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
