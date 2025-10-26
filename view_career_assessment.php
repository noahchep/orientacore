<?php
session_start();
require 'db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

// Fetch student info
$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
$student_name = $student['name'] ?? 'Unknown';
$student_email = $student['email'] ?? '';

// ✅ Fetch all career assessment results for this student
$stmt = $pdo->prepare("
    SELECT category, total_score, recommendation, created_at
    FROM student_career_results
    WHERE student_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$student_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Career Assessment Results</title>
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
    max-width: 1000px;
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
    font-size: 15px;
    color: #555;
    margin-bottom: 25px;
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
  }

  tbody tr:hover {
    background: #f9fbff;
    transition: 0.3s ease;
  }

  .recommendation {
    font-style: italic;
    color: #444;
  }

  .btn-back {
    display: inline-block;
    margin-top: 30px;
    text-decoration: none;
    background: linear-gradient(90deg, #2196f3, #1976d2);
    color: #fff;
    padding: 10px 20px;
    border-radius: 6px;
    transition: 0.3s;
  }

  .btn-back:hover {
    background: linear-gradient(90deg, #1565c0, #0d47a1);
  }

  .no-data {
    text-align: center;
    font-style: italic;
    color: #888;
    font-size: 16px;
    margin-top: 20px;
  }

  @media print {
    .btn-back { display: none; }
  }
</style>
</head>
<body>

<div class="container">
  <div class="title-bar">
    <h2>Career Assessment Results</h2>
    <div class="line"></div>
  </div>

  <div class="student-info">
    Student: <span><?= htmlspecialchars($student_name) ?></span> |
    Email: <span><?= htmlspecialchars($student_email) ?></span>
  </div>

  <?php if (count($results) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>Category</th>
        <th>Total Score</th>
        <th>Career Recommendation</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['category']) ?></td>
        <td><?= htmlspecialchars($r['total_score']) ?></td>
        <td class="recommendation">
          <?= $r['recommendation'] ? htmlspecialchars($r['recommendation']) : 'No recommendation available' ?>
        </td>
        <td><?= htmlspecialchars($r['created_at'] ?? '') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p class="no-data">You have not completed any career assessments yet.</p>
  <?php endif; ?>

  <div style="text-align:center;">
    <a href="student_view_report.php" class="btn-back">← Back to My Counseling Reports</a>
  </div>
</div>

</body>
</html>
