<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$host = 'localhost';
$dbname = 'orientacore';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $session_date = $_POST['session_date'];
    $session_topic = $_POST['session_topic'];
    $issues_discussed = $_POST['issues_discussed'];
    $counselor_remarks = $_POST['counselor_remarks'];
    $recommendations = $_POST['recommendations'];
    $next_session = $_POST['next_session'];

    $stmt = $pdo->prepare("
        INSERT INTO counselor_reports 
        (student_name, session_date, session_topic, issues_discussed, counselor_remarks, recommendations, next_session) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$student_name, $session_date, $session_topic, $issues_discussed, $counselor_remarks, $recommendations, $next_session]);

    $success = "Report saved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Counselor Session Report</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 65%;
            margin: 40px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #222;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .btn {
            margin-top: 25px;
            padding: 12px 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            display: block;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Counselor Report Form</h2>

    <?php if (!empty($success)): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="student_name">Student Name:</label>
        <input type="text" name="student_name" id="student_name" required>

        <label for="session_date">Session Date:</label>
        <input type="date" name="session_date" id="session_date" required>

        <label for="session_topic">Session Topic:</label>
        <input type="text" name="session_topic" id="session_topic" required>

        <label for="issues_discussed">Issues Discussed:</label>
        <textarea name="issues_discussed" id="issues_discussed" placeholder="Summarize the issues discussed during the session..." required></textarea>

        <label for="counselor_remarks">Counselor Remarks:</label>
        <textarea name="counselor_remarks" id="counselor_remarks" placeholder="Enter your remarks about the student's progress..." required></textarea>

        <label for="recommendations">Recommendations:</label>
        <textarea name="recommendations" id="recommendations" placeholder="Provide follow-up actions or recommendations..." required></textarea>

        <label for="next_session">Next Session Date:</label>
        <input type="date" name="next_session" id="next_session" required>

        <button type="submit" class="btn">Save Report</button>
    </form>
</div>

</body>
</html>
