<?php
session_start();
require 'db.php'; // Database connection

// Redirect if not logged in or not student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch student info including profile picture
$stmt = $pdo->prepare("SELECT name, email, profile_pic FROM users WHERE id = ?");
$stmt->execute([$userId]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$studentName  = $student['name'] ?? 'Student';
$studentEmail = $student['email'] ?? 'student@example.com';
$studentPic   = $student['profile_pic'] ?? 'pro.png';


// --- Fetch student stats ---
$stmt = $pdo->prepare("SELECT COUNT(*) FROM career_assessments WHERE user_id = ?");
$stmt->execute([$userId]);
$totalAssessments = (int)$stmt->fetchColumn();

$latestAssessment = $pdo->prepare("SELECT assessment_type, score, created_at 
    FROM career_assessments 
    WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$latestAssessment->execute([$userId]);
$latest = $latestAssessment->fetch(PDO::FETCH_ASSOC);

// --- Fetch last 5 assessments ---
$historyStmt = $pdo->prepare("SELECT assessment_type, score, created_at 
    FROM career_assessments 
    WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$historyStmt->execute([$userId]);
$history = $historyStmt->fetchAll(PDO::FETCH_ASSOC);

// Helper: determine active link
function isActive($file) {
    $self = basename($_SERVER['PHP_SELF']);
    return $self === $file ? 'active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Student Dashboard — OrientaCore</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous"/>

  <style>
    :root{
      --sidebar-bg: #1f2d3d;
      --accent: #3498db;
      --muted: #7f8c8d;
      --card-radius: 10px;
      --transition: 0.18s ease;
    }
    *{box-sizing:border-box}
    body { margin:0; font-family: "Segoe UI", Roboto, sans-serif; background:#f4f6f9; color:#2c3e50; }
    /* Sidebar */
    .sidebar { width:240px; background:linear-gradient(180deg,var(--sidebar-bg), #16232b); color:#fff; height:100vh; position:fixed; left:0; top:0; padding:20px 14px; display:flex; flex-direction:column; gap:18px; z-index:50; }
    .brand{display:flex;align-items:center;gap:10px;}
    .brand img.logo { width:40px; height:40px; border-radius:8px; }
    .brand h3 { margin:0; font-size:18px; font-weight:600; }
    .profile{display:flex;gap:10px;align-items:center;padding:8px;border-radius:8px;background:rgba(255,255,255,0.03);}
    .profile img{width:46px;height:46px;border-radius:50%;}
    nav.menu{display:flex;flex-direction:column;gap:6px;margin-top:6px;flex:1;}
    nav.menu a{display:flex;align-items:center;gap:12px;color:rgba(255,255,255,0.9);padding:10px 12px;text-decoration:none;border-radius:8px;transition:background var(--transition), transform var(--transition);font-weight:500;}
    nav.menu a:hover{background:rgba(255,255,255,0.04);transform:translateX(4px);}
    nav.menu a.active{background:linear-gradient(90deg,rgba(255,255,255,0.06),rgba(255,255,255,0.03));}
    .sidebar form{margin-top:auto;}
    .sidebar-logout{width:100%;padding:10px;border-radius:8px;background:#e74c3c;color:white;border:none;font-weight:600;cursor:pointer;display:flex;gap:8px;align-items:center;justify-content:center;}
    /* Main */
    .main{margin-left:240px;padding:20px;min-height:100vh;position:relative;}
    .main::before{content:"";position:absolute;inset:0;background:url('back.jpg') center/cover no-repeat;opacity:.6;z-index:-1;}
    header.topbar{display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-radius:10px;background:linear-gradient(90deg,#fff,#fbfdff);box-shadow:0 6px 18px rgba(15,35,55,0.06);margin-bottom:18px;}
    /* Cards */
    .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:18px;}
    .card{border-radius:var(--card-radius);padding:16px;color:white;display:flex;gap:12px;align-items:center;justify-content:space-between;box-shadow:0 6px 18px rgba(15,35,55,0.06);}
    .card .left{display:flex;gap:12px;align-items:center;}
    .card .left i{font-size:28px;}
    .assessments{background:linear-gradient(135deg,#2f80ed,#56ccf2);}
    .results{background:linear-gradient(135deg,#16a085,#2ecc71);}
    .reports{background:linear-gradient(135deg,#6a3093,#a044ff);}
    /* History table */
    .history{background:white;border-radius:10px;box-shadow:0 6px 18px rgba(15,35,55,0.06);padding:16px;}
    .history h2{margin:0 0 12px;font-size:18px;color:#2c3e50;}
    table{width:100%;border-collapse:collapse;font-size:14px;}
    table thead{background:#3498db;color:white;}
    table th, table td{padding:10px;text-align:left;}
    table tbody tr:nth-child(even){background:#f9fbfd;}
    table tbody tr:hover{background:#f1f7fc;}
    .empty{text-align:center;color:#888;padding:12px;}
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="brand">
      <img src="logo.jpg" alt="logo" class="logo">
      <h3>OrientaCore</h3>
    </div>

    <div class="profile">
      <img src="<?= htmlspecialchars($studentPic) ?>" alt="student avatar">

      <div class="meta">
        <div class="name"><?= htmlspecialchars($studentName) ?></div>
        <div class="email"><?= htmlspecialchars($studentEmail) ?></div>
      </div>
    </div>

    <nav class="menu">
      <a href="student_dashboard.php" class="<?= isActive('student_dashboard.php') ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
      <a href="assessment_test.php" class="<?= isActive('assessment_test.php') ?>"><i class="fas fa-clipboard-check"></i><span>Take Assessment</span></a>
      <a href="my_results.php" class="<?= isActive('my_results.php') ?>"><i class="fas fa-chart-line"></i><span>My Results</span></a>
      <a href="profile.php" class="<?= isActive('profile.php') ?>"><i class="fas fa-user"></i><span>Profile</span></a>
      <a href="student_career_test.php"><i class="fas fa-question-circle"></i> Career Assessment</a>
</li>


      <form action="logout.php" method="post" onsubmit="return confirm('Are you sure you want to logout?');">
        <button type="submit" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main -->
  <main class="main">
    <header class="topbar">
      <div><h1>Student Dashboard</h1></div>
      <div style="font-size:13px;color:var(--muted)">Welcome back, <?= htmlspecialchars($studentName) ?></div>
    </header>

    <!-- Cards -->
    <section class="cards">
      <div class="card assessments">
        <div class="left">
          <i class="fas fa-clipboard-check"></i>
          <div class="meta">
            <div class="num"><?= $totalAssessments ?></div>
            <div class="label">Assessments Taken</div>
          </div>
        </div>
      </div>

      <div class="card results">
        <div class="left">
          <i class="fas fa-chart-line"></i>
          <div class="meta">
            <div class="num"><?= $latest ? htmlspecialchars($latest['score']) : '—' ?></div>
            <div class="label">Latest Score</div>
          </div>
        </div>
      </div>

      <div class="card reports">
        <div class="left">
          <i class="fas fa-clock"></i>
          <div class="meta">
            <div class="num"><?= $latest ? htmlspecialchars($latest['created_at']) : '—' ?></div>
            <div class="label">Last Assessment</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Assessments -->
    <section class="history">
      <h2>Recent Assessments</h2>
      <table>
        <thead>
          <tr>
            <th>Type</th>
            <th>Score</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($history): ?>
            <?php foreach ($history as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['assessment_type']) ?></td>
                <td><?= htmlspecialchars($row['score']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="3" class="empty">No assessments yet</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>

  </main>
</body>
</html>
