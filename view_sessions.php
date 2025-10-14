<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get student ID
$student_id = $_GET['student_id'] ?? null;
if (!$student_id) {
    die("Student ID not provided.");
}

// Fetch student info
$stmt = $pdo->prepare("SELECT name, reg_no FROM users WHERE id = ? AND role='student'");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch sessions
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
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($student['name']) ?> - Counselling Sessions</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e9efff 0%, #f4f6fb 100%);
        min-height: 100vh;
        color: #333;
        display: flex;
        flex-direction: column;
    }

    header {
        background: #0b2447;
        color: white;
        padding: 18px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    header h1 {
        font-size: 20px;
        font-weight: 600;
    }

    header a.back {
        color: #e2e8f0;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }
    header a.back:hover { color: #fff; }

    main {
        width: 95%;
        max-width: 1100px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        margin: 40px auto;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        padding: 30px;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 22px;
        font-weight: 600;
        color: #0b2447;
        display: flex;
        align-items: center;
    }

    .page-title i {
        margin-right: 10px;
        color: #2563eb;
    }

    .add-session {
        background: #2563eb;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: 0.3s ease;
    }

    .add-session:hover { background: #1e40af; }
    .add-session i { margin-right: 6px; }

    table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 10px;
    }

    thead {
        background-color: #f0f4ff;
    }

    th, td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    th {
        color: #334155;
        font-weight: 600;
    }

    tr:hover td {
        background-color: #f9fbff;
        transition: 0.2s ease;
    }

    .status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        text-transform: capitalize;
    }

    .approved { background: #e6f9ed; color: #107c41; }
    .pending { background: #fff5cc; color: #8a6d1d; }
    .declined { background: #fde8e8; color: #b91c1c; }

    .empty {
        text-align: center;
        color: #6b7280;
        font-style: italic;
        padding: 25px 0;
    }
</style>
</head>

<body>
<header>
    <h1><?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['reg_no']) ?>)</h1>
    <a href="student.php" class="back"><i class="fa fa-arrow-left"></i> Back</a>
</header>

<main>
    <div class="top-bar">
        <div class="page-title"><i class="fa-solid fa-calendar-check"></i> Counselling Sessions</div>
        <a href="add_session.php?student_id=<?= $student_id ?>" class="add-session"><i class="fa fa-plus"></i> New Session</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Mode</th>
                <th>Counsellor</th>
                <th>Notes</th>
                <th>Action Plan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($sessions): ?>
            <?php foreach ($sessions as $s): 
                $status = strtolower($s['status']);
            ?>
            <tr>
                <td><?= htmlspecialchars($s['session_date']) ?></td>
                <td><?= htmlspecialchars($s['mode']) ?></td>
                <td><?= htmlspecialchars($s['counsellor_name']) ?></td>
                <td><?= htmlspecialchars($s['notes']) ?></td>
                <td><?= htmlspecialchars($s['action_plan']) ?></td>
                <td><span class="status <?= $status ?>"><?= ucfirst($status) ?></span></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="empty">No sessions found for this student.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
