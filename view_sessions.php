<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get student ID from URL
$student_id = $_GET['student_id'] ?? null;
if (!$student_id) {
    die("Student ID not provided.");
}

// Fetch student info
$stmt = $pdo->prepare("SELECT name, reg_no FROM users WHERE id = ? AND role='student'");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch sessions for this student with counsellor name
$stmt = $pdo->prepare("
    SELECT s.session_date, s.mode, u.name AS counsellor_name, s.notes, s.action_plan, s.status
    FROM sessions s
    JOIN users u ON s.counsellor_id = u.id
    WHERE s.student_id = ?
    ORDER BY s.session_date DESC
");
$stmt->execute([$student_id]);
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($student['name']) ?> - Sessions</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; padding: 30px; }
        h1 { font-weight: 600; margin-bottom: 20px; }
        .back-btn { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-btn:hover { text-decoration: underline; }
        .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        table { border-collapse: collapse; width: 100%; min-width: 900px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #e0e0e0; text-align: left; }
        th { background-color: #f8f9fa; font-weight: 600; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f3f5; transition: 0.2s; }
        .tag { padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; color: white; }
        .tag-completed { background: #28a745; }
        .tag-pending { background: #ffc107; color: #212529; }
        .tag-cancelled { background: #dc3545; }
        .add-session-btn {
    display: inline-block;
    margin-left: 15px;        /* spacing from the back button */
    padding: 8px 15px;        /* button padding */
    background-color: #28a745; /* green background */
    color: white;              /* text color */
    border-radius: 5px;        /* rounded corners */
    text-decoration: none;     /* remove underline */
    font-weight: 500;
    transition: background 0.3s;
}

.add-session-btn:hover {
    background-color: #218838; /* darker green on hover */
}

    </style>
</head>
<body>

<a class="back-btn" href="student.php"><i class="fa fa-arrow-left"></i> Back to Students</a>
<h1><?= htmlspecialchars($student['name']) ?> - Counselling Sessions</h1>
<a href="add_session.php?student_id=<?= $student_id ?>" class="add-session-btn">
    <i class="fa fa-plus"></i> Add Session
</a>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Session Date</th>
                <th>Mode</th>
                <th>Counsellor Name</th>
                <th>Notes / Summary</th>
                <th>Action Plan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($sessions): ?>
                <?php foreach($sessions as $s): ?>
                    <?php
                        $statusClass = match(strtolower($s['status'])) {
                            'completed' => 'tag-completed',
                            'pending' => 'tag-pending',
                            'cancelled' => 'tag-cancelled',
                            default => ''
                        };
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($s['session_date']) ?></td>
                        <td><?= htmlspecialchars($s['mode']) ?></td>
                        <td><?= htmlspecialchars($s['counsellor_name']) ?></td>
                        <td><?= htmlspecialchars($s['notes']) ?></td>
                        <td><?= htmlspecialchars($s['action_plan']) ?></td>
                        <td><span class="tag <?= $statusClass ?>"><?= htmlspecialchars($s['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No sessions found for this student.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


</body>
</html>
