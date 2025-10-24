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

// --- Fetch notifications ---
$stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND user_type = 'student' AND is_read = 0");
$stmt->execute([$userId]);
$unreadCount = (int)$stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT id, message, created_at, is_read FROM notifications 
                      WHERE user_id = ? AND user_type = 'student' ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$userId]);
$latestNotifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Helper function
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
    
    /* Notification Bell */
    .notification-wrapper { position: relative; cursor: pointer; }
    .notification-bell { font-size: 22px; color: #3498db; position: relative; }
    .notification-count {
      position: absolute;
      top: -6px;
      right: -6px;
      background: red;
      color: white;
      font-size: 12px;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 50%;
    }
    .notification-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 30px;
      width: 280px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      z-index: 100;
      overflow: hidden;
    }
    .notification-dropdown.active { display: block; }
    .notification-item {
      padding: 10px 12px;
      border-bottom: 1px solid #f0f0f0;
    }
    .notification-item.unread { background: #f9f9ff; }
    .notification-item small { color: #888; font-size: 12px; }
    .notification-item:last-child { border-bottom: none; }
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
      <a href="student_view_report.php" class="<?= isActive('student_view_report.php') ?>"><i class="fas fa-chart-line"></i><span>My Reports</span></a>
      <a href="student_book_session.php" class="<?= isActive('student_book_session.php') ?>"><i class="fas fa-calendar-check"></i><span>Book Session</span></a>
      <a href="profile.php" class="<?= isActive('profile.php') ?>"><i class="fas fa-user"></i><span>Profile</span></a>
   
      <form action="logout.php" method="post" onsubmit="return confirm('Are you sure you want to logout?');">
        <button type="submit" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main -->
  <main class="main">
    <header class="topbar">
      <div><h1>Student Dashboard</h1></div>
      <div style="display:flex;align-items:center;gap:20px;">
        <!-- Notification Bell -->
        <div class="notification-wrapper" id="notifBell">
          <i class="fas fa-bell notification-bell"></i>
          <?php if ($unreadCount > 0): ?>
            <span class="notification-count"><?= $unreadCount ?></span>
          <?php endif; ?>

          <div class="notification-dropdown" id="notifDropdown">
            <?php if (count($latestNotifications) > 0): ?>
              <?php foreach ($latestNotifications as $n): ?>
                <div class="notification-item <?= !$n['is_read'] ? 'unread' : '' ?>">
                  <p style="margin:0;"><?= htmlspecialchars($n['message']) ?></p>
                  <small><?= date('M d, Y h:i A', strtotime($n['created_at'])) ?></small>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="notification-item text-center">No notifications</div>
            <?php endif; ?>
          </div>
        </div>

        <div style="font-size:13px;color:var(--muted)">Welcome back, <?= htmlspecialchars($studentName) ?></div>
      </div>
    </header>

    <!-- The rest of your dashboard remains unchanged -->
    <section class="cards">
      <!-- cards here -->
    </section>

    <section class="history">
      <!-- history table here -->
    </section>
  </main>

  <script>
    const bell = document.getElementById('notifBell');
    const dropdown = document.getElementById('notifDropdown');
    bell.addEventListener('click', () => {
      dropdown.classList.toggle('active');
    });
    window.addEventListener('click', (e) => {
      if (!bell.contains(e.target)) dropdown.classList.remove('active');
    });
  </script>
</body>
</html>
