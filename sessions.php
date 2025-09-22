<?php
// sessions.php
require 'db.php';

if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    die("Student ID not provided.");
}

$student_id = intval($_GET['student_id']);

try {
    // Fetch student details
    $stmt = $pdo->prepare("SELECT id, reg_no, name FROM users WHERE id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }

    // Fetch sessions for the student
    $stmt = $pdo->prepare("SELECT s.id, s.session_date, s.mode, s.notes, s.action_plan, s.status, 
                                  u.name AS counsellor_name
                           FROM sessions s
                           JOIN users u ON s.counsellor_id = u.id
                           WHERE s.student_id = ?
                           ORDER BY s.session_date DESC");
    $stmt->execute([$student_id]);
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching sessions: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Sessions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="students.php">Students</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($student['name']) ?> Sessions</li>
        </ol>
    </nav>

    <!-- Card -->
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-lines-fill"></i>
                <?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['reg_no']) ?>)
            </h5>
            <a href="add_session.php?student_id=<?= $student['id'] ?>" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Add Session
            </a>
        </div>
        <div class="card-body">
            <?php if (empty($sessions)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No sessions found for this student.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Mode</th>
                                <th>Counsellor</th>
                                <th>Notes</th>
                                <th>Action Plan</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sessions as $s): ?>
                                <tr>
                                    <td><?= htmlspecialchars($s['session_date']) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($s['mode']) ?></span></td>
                                    <td><?= htmlspecialchars($s['counsellor_name']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#notes<?= $s['id'] ?>">
                                            View
                                        </button>
                                        <div class="collapse mt-2" id="notes<?= $s['id'] ?>">
                                            <div class="card card-body p-2 small bg-light">
                                                <?= nl2br(htmlspecialchars($s['notes'])) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#plan<?= $s['id'] ?>">
                                            View
                                        </button>
                                        <div class="collapse mt-2" id="plan<?= $s['id'] ?>">
                                            <div class="card card-body p-2 small bg-light">
                                                <?= nl2br(htmlspecialchars($s['action_plan'])) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            $badgeClass = match ($s['status']) {
                                                'Completed' => 'bg-success',
                                                'Pending'   => 'bg-warning text-dark',
                                                'Cancelled' => 'bg-danger',
                                                default     => 'bg-secondary'
                                            };
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= htmlspecialchars($s['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_session.php?id=<?= $s['id'] ?>&student_id=<?= $student['id'] ?>" 
                                           class="btn btn-sm btn-primary">
                                           <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete_session.php?id=<?= $s['id'] ?>&student_id=<?= $student['id'] ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this session?')">
                                           <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <a href="students.php" class="btn btn-secondary btn-sm mt-3">
                <i class="bi bi-arrow-left"></i> Back to Students
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
