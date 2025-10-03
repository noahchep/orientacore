<?php
session_start();
require 'db.php'; // Database connection

// Redirect if not logged in or not a counsellor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'counsellor') {
    header("Location: login.php");
    exit;
}

$counsellorName = $_SESSION['name'] ?? 'Counsellor';
$counsellorEmail = $_SESSION['email'] ?? 'counsellor@example.com';

// Total students (all students, or you can filter by counsellor if needed)
$totalStudents = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();

// --- Fetch stats ---
$pendingSessions = (int)$pdo->query("SELECT COUNT(*) FROM sessions WHERE counsellor_id = ".$_SESSION['user_id']." AND status='open'")->fetchColumn();
$totalSessions = (int)$pdo->query("SELECT COUNT(*) FROM sessions WHERE counsellor_id = ".$_SESSION['user_id'])->fetchColumn();

// --- Fetch recent sessions ---
$recentSessionsQuery = $pdo->prepare("SELECT s.id, u.name AS student_name, s.session_date, s.status 
                                      FROM sessions s 
                                      JOIN users u ON s.student_id = u.id 
                                      WHERE s.counsellor_id = ? 
                                      ORDER BY s.session_date DESC LIMIT 20");

$recentSessionsQuery->execute([$_SESSION['user_id']]);
$recentSessions = $recentSessionsQuery->fetchAll(PDO::FETCH_ASSOC);

// Helper for active links
function isActive($file) {
    return basename($_SERVER['PHP_SELF']) === $file ? 'active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Counsellor Dashboard — OrientaCore</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    /* Use admin dashboard styles for consistency */
    :root{--sidebar-bg:#1f2d3d;--accent:#3498db;--muted:#7f8c8d;--card-radius:10px;--transition:0.18s ease;}
    *{box-sizing:border-box;}
    body{margin:0;font-family:"Segoe UI",Roboto,Helvetica,Arial,sans-serif;background:#f4f6f9;color:#2c3e50;}
    .sidebar{width:240px;background:linear-gradient(180deg,var(--sidebar-bg),#16232b);color:#fff;height:100vh;position:fixed;left:0;top:0;padding:20px 14px;display:flex;flex-direction:column;gap:18px;z-index:50;}
    .brand{display:flex;align-items:center;gap:10px;margin-bottom:6px;}
    .brand img.logo{width:40px;height:40px;border-radius:8px;object-fit:cover;box-shadow:0 2px 6px rgba(0,0,0,0.2);}
    .brand h3{margin:0;font-size:18px;letter-spacing:0.2px;font-weight:600;}
    .profile{display:flex;gap:10px;align-items:center;padding:8px;border-radius:8px;background: rgba(255,255,255,0.03);}
    .profile img{width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.08);}
    .profile .meta{font-size:13px;}
    .profile .meta .name{font-weight:600;}
    .profile .meta .email{color: rgba(255,255,255,0.75);font-size:12px;margin-top:3px;}
    nav.menu{display:flex;flex-direction:column;gap:6px;margin-top:6px;flex:1;}
    nav.menu a{display:flex;align-items:center;gap:12px;color:rgba(255,255,255,0.9);padding:10px 12px;text-decoration:none;border-radius:8px;transition:background var(--transition), transform var(--transition);font-weight:500;}
    nav.menu a i{width:18px;text-align:center;font-size:16px;color:rgba(255,255,255,0.95);}
    nav.menu a:hover{background: rgba(255,255,255,0.04);transform:translateX(4px);}
    nav.menu a.active{background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02);}
    .sidebar form{margin-top:12px;}
    .sidebar-logout{width:100%;padding:10px;border-radius:8px;background:#e74c3c;color:white;border:none;font-weight:600;cursor:pointer;display:flex;gap:8px;align-items:center;justify-content:center;transition: background var(--transition), transform var(--transition);}
    .sidebar-logout i{font-size:14px;}
    .sidebar-logout:hover{background:#c43b2f;transform: translateY(-2px);}
    .main{margin-left:240px;padding:20px;flex:1;min-height:100vh;position:relative;z-index:1;}
    header.topbar{display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-radius:10px;background: linear-gradient(90deg, #fff, #fbfdff);box-shadow: 0 6px 18px rgba(15,35,55,0.06);margin-bottom:18px;gap:12px;}
    .topbar-left h1{margin:0;font-size:18px;color:var(--muted);font-weight:700;}
    .cards{display:grid;grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:18px;}
    .card{border-radius: var(--card-radius);padding:16px;color:white;display:flex;gap:12px;align-items:center;justify-content:space-between;box-shadow: 0 6px 18px rgba(15,35,55,0.06);transition: transform var(--transition), box-shadow var(--transition);}
    .card:hover{transform: translateY(-6px);box-shadow: 0 14px 40px rgba(15,35,55,0.12);}
    .card .left{display:flex;gap:12px;align-items:center;}
    .card .left i{font-size:28px;opacity:0.95;}
    .card .left .meta{text-align:left;}
    .card .left .meta .num{font-size:20px;font-weight:700;}
    .card .left .meta .label{font-size:13px;opacity:0.95;}
    .card .action{font-size:12px;opacity:0.9;}
    .students{background: linear-gradient(135deg,#2f80ed,#56ccf2);}
    .pending{background: linear-gradient(135deg,#f2994a,#f2c94c);color:#222;}
    .users{background: linear-gradient(135deg,#6a3093,#a044ff);}
    .card-table{background:white;border-radius:10px;padding:12px;box-shadow: 0 8px 24px rgba(15,35,55,0.06);}
    table.recent{width:100%;border-collapse:collapse;font-size:14px;}
    table.recent thead th{padding:10px;text-align:left;background:#f7fafc;color:#34495e;font-weight:700;}
    table.recent td{padding:10px;border-bottom:1px solid #f1f3f5;}
    .badge{padding:6px 10px;border-radius:999px;font-size:12px;font-weight:600;display:inline-block;}
    .badge.success{background:#2ecc71;color:white;}
    .badge.pending{background:#f39c12;color:white;}
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
      <img src="pro.png" alt="avatar">
      <div class="meta">
        <div class="name"><?= htmlspecialchars($counsellorName) ?></div>
        <div class="email"><?= htmlspecialchars($counsellorEmail) ?></div>
      </div>
    </div>

    <nav class="menu">
      <a href="counsellor_dashboard.php" class="<?= isActive('counsellor_dashboard.php') ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
      <a href="sessions.php" class="<?= isActive('sessions.php') ?>"><i class="fas fa-calendar-alt"></i><span>Sessions</span></a>
      <a href="career_assessment.php" class="<?= isActive('career_assessment.php') ?>"><i class="fas fa-chart-line"></i><span>Career Assessment</span></a>
      <a href="student_progress.php" class="<?= isActive('student_progress.php') ?>"><i class="fas fa-user-graduate"></i><span>Student Progress</span></a>
      <a href="reports.php" class="<?= isActive('reports.php') ?>"><i class="fas fa-file-alt"></i><span>Reports</span></a>
      <form action="logout.php" method="post" style="margin-top:auto;">
        <button type="submit" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
      </form>
    </nav>
  </aside>

  <main class="main">
    <header class="topbar">
      <div class="topbar-left">
        <h1>Counsellor Dashboard</h1>
        <div style="margin-left:12px;color:var(--muted);font-size:13px;">Manage sessions, students & reports</div>
      </div>
    </header>

    <!-- Stat cards -->
    <section class="cards">
      <div class="card students" title="Total students">
        <div class="left">
          <i class="fas fa-user-graduate"></i>
          <div class="meta"><div class="num"><?= $totalStudents ?></div><div class="label">Total Students</div></div>
        </div>
        <div class="action"><a href="student_progress.php" style="color:inherit;text-decoration:none;font-size:13px;">View</a></div>
      </div>

      <div class="card pending" title="Pending sessions">
        <div class="left">
          <i class="fas fa-hourglass-half"></i>
          <div class="meta"><div class="num"><?= $pendingSessions ?></div><div class="label">Pending Sessions</div></div>
        </div>
        <div class="action"><a href="sessions.php?status=open" style="color:inherit;text-decoration:none;font-size:13px;">Manage</a></div>
      </div>

      <div class="card users" title="Total sessions">
        <div class="left">
          <i class="fas fa-users"></i>
          <div class="meta"><div class="num"><?= $totalSessions ?></div><div class="label">Total Sessions</div></div>
        </div>
        <div class="action"><a href="sessions.php" style="color:inherit;text-decoration:none;font-size:13px;">View</a></div>
      </div>
    </section>

    <!-- Recent sessions table -->
    <section class="card-table">
      <h2>Recent Sessions</h2>
      <div style="overflow:auto;">
        <table class="recent">
          <thead>
            <tr>
              <th>ID</th>
              <th>Student</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($recentSessions): foreach($recentSessions as $s): ?>
            <tr>
              <td><?= $s['id'] ?></td>
              <td><?= htmlspecialchars($s['student_name']) ?></td>
              <td><?= htmlspecialchars($s['session_date']) ?></td>
              <td><span class="badge <?= $s['status']=='open'?'pending':'success' ?>"><?= ucfirst($s['status']) ?></span></td>
              <td>
                <a class="action-btn" href="view_session.php?id=<?= $s['id'] ?>"><i class="fas fa-eye"></i></a>
                <a class="action-btn" href="edit_session.php?id=<?= $s['id'] ?>"><i class="fas fa-edit"></i></a>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="5" style="text-align:center;padding:20px;">No recent sessions</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>
