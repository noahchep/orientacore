<?php
session_start();
require 'db.php';

// Only students can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

// -------------------------
// Fetch student responses
// -------------------------
$stmt = $pdo->prepare("SELECT q.question_text, f.selected_option, f.category, f.created_at
                       FROM Full_texts f
                       JOIN questions q ON f.question_id = q.id
                       WHERE f.student_id = ?");
$stmt->execute([$student_id]);
$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------------
// Fetch academic results
// -------------------------
$stmt2 = $pdo->prepare("SELECT course_name, grade, semester, created_at 
                        FROM results 
                        WHERE student_id = ?");
$stmt2->execute([$student_id]);
$results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// -------------------------
// Fetch booked sessions
// -------------------------
$stmt3 = $pdo->prepare("SELECT session_date, counselor_name, status 
                        FROM sessions 
                        WHERE student_id = ?");
$stmt3->execute([$student_id]);
$sessions = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// -------------------------
// Handle new session booking
// -------------------------
if (isset($_POST['book_session'])) {
    $date = $_POST['session_date'];
    $counselor = $_POST['counselor_name'];

    $stmt4 = $pdo->prepare("INSERT INTO sessions (student_id, session_date, counselor_name, status) 
                            VALUES (?, ?, ?, 'pending')");
    $stmt4->execute([$student_id, $date, $counselor]);

    header("Location: " . $_SERVER['PHP_SELF']); // Refresh page
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        h1, h2, h3 { font-weight: 600; }
        .section { margin-bottom: 40px; }
        .table-container { overflow-x: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        table { border-collapse: collapse; width: 100%; min-width: 700px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background-color: #f8f9fa; font-weight: 600; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f3f5; transition: 0.2s; }
        .book-btn { padding: 8px 15px; background: #28a745; color: white; border-radius: 5px; text-decoration: none; font-weight: 500; }
        .book-btn:hover { background: #218838; }
        .book-form { margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 10px; }
        .book-form input, .book-form select, .book-form button { padding: 7px 10px; border-radius: 5px; border: 1px solid #ccc; }
        .book-form button { background: #007bff; color: white; border: none; cursor: pointer; }
        .book-form button:hover { background: #0069d9; }
    </style>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h1>

    <!-- Responses Section -->
    <div class="section">
        <h2>Your Responses</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Selected Option</th>
                        <th>Category</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($responses): ?>
                        <?php foreach($responses as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['question_text']) ?></td>
                                <td><?= htmlspecialchars($r['selected_option']) ?></td>
                                <td><?= htmlspecialchars($r['category']) ?></td>
                                <td><?= date("d M Y", strtotime($r['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No responses found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Academic Results Section -->
    <div class="section">
        <h2>Academic Results</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Grade</th>
                        <th>Semester</th>
                        <th>Date Recorded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results): ?>
                        <?php foreach($results as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars($res['course_name']) ?></td>
                                <td><?= htmlspecialchars($res['grade']) ?></td>
                                <td><?= htmlspecialchars($res['semester']) ?></td>
                                <td><?= date("d M Y", strtotime($res['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No results found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Book Session Section -->
    <div class="section">
        <h2>Book a Session</h2>
        <form method="POST" class="book-form">
            <input type="datetime-local" name="session_date" required>
            <input type="text" name="counselor_name" placeholder="Counselor Name" required>
            <button type="submit" name="book_session"><i class="fa fa-plus"></i> Book Session</button>
        </form>

        <h3>Your Sessions</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Counselor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($sessions): ?>
                        <?php foreach($sessions as $s): ?>
                            <tr>
                                <td><?= date("d M Y, H:i", strtotime($s['session_date'])) ?></td>
                                <td><?= htmlspecialchars($s['counselor_name']) ?></td>
                                <td><?= htmlspecialchars(ucfirst($s['status'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No sessions booked.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
