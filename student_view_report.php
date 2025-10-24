<?php
session_start();
require 'db.php';

// Make sure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

// Fetch the student's name
$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
$student_name = $student ? $student['name'] : '';

$reports = [];

try {
    // Fetch all reports written for this student
    $stmt = $pdo->prepare("SELECT * FROM counselor_reports WHERE student_name = ? ORDER BY created_at DESC");
    $stmt->execute([$student_name]);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Counseling Reports</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: "Poppins", "Segoe UI", sans-serif;
      background: linear-gradient(135deg, #e9f2fa, #ffffff);
      margin: 0;
      padding: 40px 0;
      color: #333;
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      background: #fff;
      padding: 40px 50px;
      border-radius: 18px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .title-bar {
      text-align: center;
      margin-bottom: 35px;
    }

    .title-bar h2 {
      font-size: 1.9em;
      color: #1e3c72;
      font-weight: 600;
      margin: 0;
    }

    .title-bar .line {
      width: 80px;
      height: 4px;
      margin: 10px auto 0;
      border-radius: 4px;
      background: linear-gradient(90deg, #1976d2, #42a5f5);
    }

    .student-info {
      text-align: center;
      font-size: 16px;
      color: #555;
      margin-bottom: 15px;
    }

    .student-info span {
      color: #1976d2;
      font-weight: 600;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }

    thead th {
      background: linear-gradient(90deg, #1976d2, #2196f3);
      color: #fff;
      padding: 14px;
      font-weight: 600;
      text-align: left;
    }

    tbody td {
      background: #fff;
      border-bottom: 1px solid #f1f1f1;
      padding: 12px 14px;
      font-size: 15px;
      vertical-align: top;
      animation: fadeRow 0.5s ease;
    }

    @keyframes fadeRow {
      from {opacity: 0;}
      to {opacity: 1;}
    }

    tbody tr:hover {
      background: #f9fbff;
      transition: 0.3s ease;
    }

    .btn {
      background: linear-gradient(90deg, #2196f3, #1976d2);
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background: linear-gradient(90deg, #1565c0, #0d47a1);
      box-shadow: 0 3px 8px rgba(33, 150, 243, 0.4);
    }

    .no-report {
      text-align: center;
      color: #777;
      font-style: italic;
      margin-top: 30px;
      font-size: 16px;
    }

    @media print {
      body {
        background: #fff;
      }
      .btn {
        display: none !important;
      }
      .container {
        box-shadow: none;
        border: none;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="title-bar">
      <h2>My Counseling Reports</h2>
      <div class="line"></div>
    </div>

    <div class="student-info">
      Logged in as: <span><?= htmlspecialchars($student_name) ?></span>
    </div>

    <?php if (count($reports) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Date</th>
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
                <form method="post" action="print_report.php" target="_blank">
                  <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                  <button type="submit" class="btn">Generate</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-report">No reports available for you yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
