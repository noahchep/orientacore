<?php
session_start();
require 'db.php'; // Database connection

//Redirect if not logged in or not admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$adminName = $_SESSION['name'] ?? 'Admin';
$adminEmail = $_SESSION['email'] ?? 'admin@example.com';

// --- Fetch stats from DB ---
$totalUsers = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalStudents = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
$totalCounsellors = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'counsellor'")->fetchColumn();
$pendingRequests = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student' AND LOWER(status) = 'pending'")->fetchColumn();


// --- Fetch recent activity (last 20 users registered) ---
$recentQuery = $pdo->query("SELECT id, name, role, status, created_at FROM users ORDER BY created_at DESC LIMIT 20");
$recentUsers = $recentQuery->fetchAll(PDO::FETCH_ASSOC);

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
  <title>Admin Dashboard — OrientaCore</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    :root{
      --sidebar-bg: #1f2d3d;
      --accent: #3498db;
      --muted: #7f8c8d;
      --card-radius: 10px;
      --transition: 0.18s ease;
    }
    *{box-sizing:border-box}
    body {
      margin:0;
      font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      background:#f4f6f9;
      color:#2c3e50;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* ===== Sidebar ===== */
    .sidebar {
      width: 240px;
      background: linear-gradient(180deg,var(--sidebar-bg), #16232b);
      color: #fff;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      padding: 20px 14px;
      display: flex;
      flex-direction: column;
      gap: 18px;
      z-index: 50;
    }
    .brand {
      display:flex;
      align-items:center;
      gap:10px;
      margin-bottom:6px;
    }
    .brand img.logo {
      width:40px; height:40px; border-radius:8px; object-fit:cover;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .brand h3 { margin:0; font-size:18px; letter-spacing:0.2px; font-weight:600; }

    .profile {
      display:flex;
      gap:10px;
      align-items:center;
      padding:8px;
      border-radius:8px;
      background: rgba(255,255,255,0.03);
    }
    .profile img {
      width:46px; height:46px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,0.08);
    }
    .profile .meta { font-size:13px; }
    .profile .meta .name { font-weight:600; }
    .profile .meta .email { color: rgba(255,255,255,0.75); font-size:12px; margin-top:3px; }

    nav.menu { display:flex; flex-direction:column; gap:6px; margin-top:6px; flex:1; }
    nav.menu a {
      display:flex; align-items:center; gap:12px;
      color:rgba(255,255,255,0.9);
      padding:10px 12px; text-decoration:none; border-radius:8px;
      transition: background var(--transition), transform var(--transition);
      font-weight:500;
    }
    nav.menu a i { width:18px; text-align:center; font-size:16px; color:rgba(255,255,255,0.95); }
    nav.menu a:hover { background: rgba(255,255,255,0.04); transform:translateX(4px); }
    nav.menu a.active { background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03)); box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02); }

    /* logout button in sidebar */
    .sidebar form { margin-top: 12px; }
    .sidebar-logout {
      width:100%;
      padding:10px;
      border-radius:8px;
      background:#e74c3c;
      color:white;
      border:none;
      font-weight:600;
      cursor:pointer;
      display:flex;
      gap:8px;
      align-items:center;
      justify-content:center;
      transition: background var(--transition), transform var(--transition);
    }
    .sidebar-logout i { font-size:14px; }
    .sidebar-logout:hover { background:#c43b2f; transform: translateY(-2px); }

    /* ===== Main area ===== */
    .main {
      margin-left:240px;
      padding:20px;
      flex:1;
      min-height:100vh;
      position:relative;
      z-index:1;
    }

    /* background image (subtle) */
    .main::before {
      content: "";
      position: absolute;
      inset:0;
      background: url('back.jpg') center center / cover no-repeat;
      opacity: 0.6;
      z-index:-1;
      filter: saturate(0.8);
    }

    header.topbar {
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:14px 20px;
      border-radius:10px;
      background: linear-gradient(90deg, #fff, #fbfdff);
      box-shadow: 0 6px 18px rgba(15,35,55,0.06);
      margin-bottom:18px;
      gap:12px;
    }
    .topbar-left { display:flex; gap:12px; align-items:center; }
    .topbar-left h1 { margin:0; font-size:18px; color:var(--muted); font-weight:700; }
    .topbar-right { display:flex; gap:12px; align-items:center; }

    /* notifications */
    .notifications {
      position:relative;
    }
    .notif-btn {
      background:transparent; border:0; cursor:pointer; font-size:18px; padding:8px; border-radius:8px;
      display:flex; gap:8px; align-items:center; color:var(--muted);
    }
    .notif-badge {
      background:#e74c3c; color:white; font-size:11px; padding:3px 7px; border-radius:999px; margin-left:-8px; margin-top:-6px;
    }
    .notif-panel {
      position:absolute; right:0; top:42px; width:320px; background:white; border-radius:8px; box-shadow: 0 10px 30px rgba(15,35,55,0.12);
      overflow:hidden; display:none; z-index:100;
    }
    .notif-panel.active { display:block; }
    .notif-panel .item { padding:12px; border-bottom:1px solid #f1f3f5; display:flex; gap:10px; align-items:center; }
    .notif-panel .item .icon { width:38px; height:38px; border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; }
    .notif-panel .item .text { font-size:13px; color:#2c3e50; }
    .notif-panel .item:last-child { border-bottom:none; }

    /* cards */
    .cards {
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap:16px;
      margin-bottom:18px;
    }
    .card {
      border-radius: var(--card-radius);
      padding:16px;
      color: white;
      display:flex;
      gap:12px;
      align-items:center;
      justify-content:space-between;
      box-shadow: 0 6px 18px rgba(15,35,55,0.06);
      transition: transform var(--transition), box-shadow var(--transition);
    }
    .card:hover { transform: translateY(-6px); box-shadow: 0 14px 40px rgba(15,35,55,0.12); }
    .card .left { display:flex; gap:12px; align-items:center; }
    .card .left i { font-size:28px; opacity:0.95; }
    .card .left .meta { text-align:left; }
    .card .left .meta .num { font-size:20px; font-weight:700; }
    .card .left .meta .label { font-size:13px; opacity:0.95; }
    .card .action { font-size:12px; opacity:0.9; }

    .students { background: linear-gradient(135deg,#2f80ed,#56ccf2); }
    .counsellors { background: linear-gradient(135deg,#16a085,#2ecc71); }
    .users { background: linear-gradient(135deg,#6a3093,#a044ff); }
    .pending { background: linear-gradient(135deg,#f2994a,#f2c94c); color: #222; }

    /* quick floating button */
    .fab {
      position: fixed;
      right: 26px;
      bottom: 26px;
      width:56px; height:56px;
      background: var(--accent);
      color:white; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      font-size:20px; box-shadow: 0 14px 30px rgba(52,152,219,0.18);
      transition: transform .14s ease, box-shadow .14s ease;
      z-index:120;
    }
    .fab:hover { transform: translateY(-4px); box-shadow: 0 22px 46px rgba(52,152,219,0.24); }

    /* recent activity table */
    .card-table { background:white; border-radius:10px; padding:12px; box-shadow: 0 8px 24px rgba(15,35,55,0.06); }
    .table-actions { display:flex; gap:8px; align-items:center; }
    table.recent { width:100%; border-collapse:collapse; font-size:14px; }
    table.recent thead th { text-align:left; padding:10px; background:#f7fafc; color: #34495e; font-weight:700; }
    table.recent tbody tr:nth-child(odd) { background:#ffffff; }
    table.recent tbody tr:nth-child(even) { background:#fbfcfd; }
    table.recent td { padding:10px; border-bottom:1px solid #f1f3f5; vertical-align:middle; }
    .badge { padding:6px 10px; border-radius:999px; font-size:12px; font-weight:600; display:inline-block; }
    .badge.success { background:#2ecc71; color:white; }
    .badge.pending { background:#f39c12; color:white; }
    .badge.inactive { background:#95a5a6; color:white; }
    .action-btn { background:transparent; border:0; cursor:pointer; color:var(--muted); padding:6px; border-radius:6px; }
    .action-btn:hover { background:rgba(0,0,0,0.04); color:#2c3e50; transform: translateY(-2px); }

    /* search */
    .search-row { display:flex; gap:8px; margin-bottom:12px; }
    .search-row input { flex:1; padding:10px; border-radius:8px; border:1px solid #e6eef6; outline:none; box-shadow:none; }

    /* responsive */
    @media (max-width:900px) {
      .sidebar { width:72px; padding:12px; }
      .brand h3 { display:none; }
      .profile .meta { display:none; }
      .main { margin-left:72px; padding:12px; }
      nav.menu a { justify-content:center; padding:10px 0; }
      nav.menu a span { display:none; }
      .cards { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
      header.topbar { flex-direction:column; align-items:flex-start; gap:8px; }
      .notif-panel { right: 8px; left: auto; width: 90vw; max-width: 360px; }
      .fab { right: 14px; bottom: 14px; }
    }
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
      <img src="pro.jpg" alt="admin avatar">
      <div class="meta">
        <div class="name"><?= htmlspecialchars($adminName) ?></div>
        <div class="email"><?= htmlspecialchars($adminEmail) ?></div>
      </div>
    </div>

    <nav class="menu" role="navigation">
      <a href="admin_dashboard.php" class="<?= isActive('admin_dashboard.php') ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
      <a href="manage_users.php" class="<?= isActive('manage_users.php') ?>"><i class="fas fa-users"></i><span>Manage Users</span></a>
      <a href="#" class=""><i class="fas fa-user-tie"></i><span>Counsellors</span></a>
      <a href="student.php" class=""><i class="fas fa-user-graduate"></i><span>Students</span></a>
      <a href="#" class=""><i class="fas fa-chart-line"></i><span>Reports</span></a>
      <a href="#" class=""><i class="fas fa-cog"></i><span>Settings</span></a>
      <a href="admin_career_library.php"><i class="fas fa-list-ul"></i> <span>Career Assessment</span></a>
     <a href="admin_view_assessment.php"><i class="fas fa-chart-pie"></i> <span>Career Assessment Reports</span></a>



      <form action="logout.php" method="post" style="margin-top:auto;">
        <button type="submit" class="sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="main">
    <header class="topbar">
      <div class="topbar-left">
        <h1>Admin Dashboard</h1>
        <div style="margin-left:12px; color:var(--muted); font-size:13px;">Manage users, sessions & reports</div>
      </div>

      <div class="topbar-right">
        <!-- notifications -->
        <div class="notifications">
          <button class="notif-btn" id="notifToggle" title="Notifications">
            <i class="fas fa-bell"></i>
            <?php if($pendingRequests>0): ?>
              <span class="notif-badge"><?= $pendingRequests ?></span>
            <?php endif; ?>
          </button>
          <div class="notif-panel" id="notifPanel" aria-hidden="true">
            <div class="item">
              <div class="icon" style="background:#f39c12"><i class="fas fa-hourglass-half"></i></div>
              <div class="text"><strong><?= $pendingRequests ?> pending student(s)</strong><div style="font-size:12px; color:#556; margin-top:6px;">Students awaiting approval</div></div>
            </div>
            <div class="item">
              <div class="icon" style="background:#56ccf2"><i class="fas fa-users"></i></div>
              <div class="text"><strong><?= $totalUsers ?> total users</strong><div style="font-size:12px; color:#556; margin-top:6px;">Current system users</div></div>
            </div>
          </div>
        </div>

        <!-- small profile quick -->
        <div style="display:flex; align-items:center; gap:12px;">
          <div style="text-align:right; font-size:13px;">
            <div style="font-weight:700;"><?= htmlspecialchars($adminName) ?></div>
            <div style="color:var(--muted); font-size:12px;"><?= htmlspecialchars($adminEmail) ?></div>
          </div>
          <img src="pro.jpg" alt="avatar" style="width:44px;height:44px;border-radius:8px;object-fit:cover;box-shadow:0 3px 10px rgba(0,0,0,0.08)">
        </div>
      </div>
    </header>

    <!-- Stat cards -->
    <section class="cards" aria-label="summary cards">
      <div class="card students" title="Total students">
        <div class="left">
          <i class="fas fa-user-graduate"></i>
          <div class="meta"><div class="num"><?= $totalStudents ?></div><div class="label">Total Students</div></div>
        </div>
        <div class="action"><a href="manage_users.php?role=student" style="color:inherit; text-decoration:none; font-size:13px;">Manage</a></div>
      </div>

      <div class="card counsellors" title="Total counsellors">
        <div class="left">
          <i class="fas fa-user-tie"></i>
          <div class="meta"><div class="num"><?= $totalCounsellors ?></div><div class="label">Total Counsellors</div></div>
        </div>
        <div class="action"><a href="manage_users.php?role=counsellor" style="color:inherit; text-decoration:none; font-size:13px;">Manage</a></div>
      </div>

      <div class="card users" title="Total users">
        <div class="left">
          <i class="fas fa-users"></i>
          <div class="meta"><div class="num"><?= $totalUsers ?></div><div class="label">Total Users</div></div>
        </div>
        <div class="action"><a href="manage_users.php" style="color:inherit; text-decoration:none; font-size:13px;">View</a></div>
      </div>

      <div class="card pending" title="Pending requests">
        <div class="left">
          <i class="fas fa-hourglass-half"></i>
          <div class="meta"><div class="num"><?= $pendingRequests ?></div><div class="label">Pending Requests</div></div>
        </div>
        <div class="action"><a href="manage_users.php?status=pending" style="color:inherit; text-decoration:none; font-size:13px;">Review</a></div>
      </div>
    </section>

    <!-- quick search + recent activity table -->
    <section class="card-table" aria-labelledby="recent-activity">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <div style="display:flex; gap:12px; align-items:center;">
          <h2 id="recent-activity" style="margin:0; font-size:18px;">Recent Activity</h2>
          <div style="color:var(--muted); font-size:13px;">(latest registrations)</div>
        </div>

        <div style="display:flex; gap:8px; align-items:center;">
          <div class="search-row" style="margin:0;">
            <input type="search" id="searchInput" placeholder="Search name, role, status..." aria-label="Search recent activity">
          </div>
        </div>
      </div>

      <div style="overflow:auto;">
        <table class="recent" id="recentTable" role="table" aria-describedby="recent-activity">
          <thead>
            <tr>
              <th style="width:6%;">ID</th>
              <th style="width:36%;">Name</th>
              <th style="width:18%;">Role</th>
              <th style="width:16%;">Status</th>
              <th style="width:16%;">Date</th>
              <th style="width:8%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($recentUsers): foreach($recentUsers as $u): ?>
              <tr data-search="<?= htmlspecialchars(strtolower($u['name'].' '.$u['role'].' '.$u['status'])) ?>">
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars(ucfirst($u['role'])) ?></td>
                <td>
                  <?php
                    $s = $u['status'];
                    if ($s === 'active' || $s === 'approved') echo '<span class="badge success">Active</span>';
                    elseif ($s === 'pending') echo '<span class="badge pending">Pending</span>';
                    else echo '<span class="badge inactive">'.htmlspecialchars($s).'</span>';
                  ?>
                </td>
                <td><?= htmlspecialchars($u['created_at']) ?></td>
                <td>
                  <div class="table-actions">
                    <a class="action-btn" href="view_user.php?id=<?= $u['id'] ?>" title="View"><i class="fas fa-eye"></i></a>
                    <a class="action-btn" href="view_user.php?id=<?= $u['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
                    <form method="post" action="delete_user.php" style="display:inline;">
                      <input type="hidden" name="id" value="<?= $u['id'] ?>">
                      <button type="submit" class="action-btn" title="Delete" onclick="return confirm('Delete this user?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="6" style="text-align:center; padding:20px;">No recent activity</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

  </main>

  <!-- Floating action button -->
  <a href="add_user.php" class="fab" title="Add user"><i class="fas fa-plus"></i></a>

  <script>
    // notif toggle
    const notifToggle = document.getElementById('notifToggle');
    const notifPanel = document.getElementById('notifPanel');
    if(notifToggle && notifPanel){
      notifToggle.addEventListener('click', (e)=>{
        e.stopPropagation();
        notifPanel.classList.toggle('active');
      });
      document.addEventListener('click', (e)=>{
        if(!notifPanel.contains(e.target)) notifPanel.classList.remove('active');
      });
    }

    // client-side search filter for recent activity
    const searchInput = document.getElementById('searchInput');
    const recentTable = document.getElementById('recentTable');
    if(searchInput){
      searchInput.addEventListener('input', function(){
        const q = this.value.trim().toLowerCase();
        const rows = recentTable.querySelectorAll('tbody tr');
        rows.forEach(r=>{
          const t = r.getAttribute('data-search') || '';
          r.style.display = (q === '' || t.indexOf(q) !== -1) ? '' : 'none';
        });
      });
    }
  </script>
</body>
</html>
