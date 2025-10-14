<?php
session_start();
require 'db.php'; // must create $pdo

// Redirect if not logged in or not student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch student info including profile picture
$stmt = $pdo->prepare("SELECT id, reg_no, name, email, profile_pic FROM users WHERE id = ?");
$stmt->execute([$userId]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$studentName  = $student['name'] ?? 'Student';
$studentEmail = $student['email'] ?? 'student@example.com';
$studentPic   = $student['profile_pic'] ?? 'pro.png';
$studentReg   = $student['reg_no'] ?? '—';

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

// --- Fetch notifications (count + latest 6) ---
$stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND user_type = 'student' AND is_read = 0");
$stmt->execute([$userId]);
$unreadCount = (int)$stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT id, message, created_at, is_read FROM notifications 
                      WHERE user_id = ? AND user_type = 'student' ORDER BY created_at DESC LIMIT 6");
$stmt->execute([$userId]);
$latestNotifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Fetch upcoming 5 sessions for this student ---
$upcomingStmt = $pdo->prepare("SELECT s.id, s.session_date, s.mode, s.status, u.name AS counsellor_name
    FROM sessions s
    LEFT JOIN users u ON s.counsellor_id = u.id
    WHERE s.student_id = ? 
    ORDER BY s.session_date ASC
    LIMIT 5");
$upcomingStmt->execute([$userId]);
$upcoming = $upcomingStmt->fetchAll(PDO::FETCH_ASSOC);

// Helper function
function isActive($file) {
    $self = basename($_SERVER['PHP_SELF']);
    return $self === $file ? 'active' : '';
}

// small helper to format datetime nicely
function fmt($dt) {
    if (!$dt) return '—';
    return date('M d, Y — H:i', strtotime($dt));
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Student Dashboard — OrientaCore</title>

  <!-- font + icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root{
      --bg: #f6f8fb;
      --card: #ffffff;
      --muted: #6b7280;
      --accent: #2563eb; /* blue */
      --accent-600: #1e40af;
      --success: #16a34a;
      --danger: #dc2626;
      --glass: rgba(255,255,255,0.7);
      --radius: 10px;
      --shadow: 0 6px 20px rgba(16,24,40,0.08);
      --soft-shadow: 0 3px 12px rgba(16,24,40,0.06);
    }

    *{box-sizing:border-box}
    body{font-family:"Inter",system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial; margin:0;background:var(--bg); color:#0f172a; -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;}
    a{color:var(--accent); text-decoration:none;}
    a:hover{text-decoration:underline;}

    /* Layout */
    .shell{max-width:1200px;margin:28px auto;padding:20px;}
    .top {display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px;}
    .brand {display:flex;gap:14px;align-items:center;}
    .logo {width:48px;height:48px;border-radius:10px;object-fit:cover;box-shadow:var(--soft-shadow);background:white;padding:6px;}
    .title {font-size:20px;font-weight:700;color:#0b2447;}
    .subtitle {font-size:13px;color:var(--muted);margin-top:4px;}

    /* Header actions */
    .actions {display:flex;align-items:center;gap:12px;}
    .notif {position:relative;cursor:pointer;}
    .notif .count{position:absolute;top:-6px;right:-8px;background:var(--danger);color:white;font-size:12px;padding:3px 7px;border-radius:999px;font-weight:700;box-shadow:0 1px 0 rgba(0,0,0,0.06);}
    .btn {background:var(--accent);color:white;padding:9px 14px;border-radius:8px;border:0;font-weight:600;cursor:pointer;display:inline-flex;gap:8px;align-items:center;}
    .btn.secondary{background:transparent;color:var(--accent);border:1px solid rgba(37,99,235,0.12);}
    .btn:active{transform:translateY(1px)}

    /* Grid */
    .grid {display:grid;grid-template-columns: 320px 1fr;gap:18px;}
    @media (max-width:920px){ .grid{grid-template-columns:1fr; } .top{flex-direction:column;align-items:flex-start} }

    /* Left column */
    .profile-card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);padding:18px;display:flex;gap:12px;align-items:center;}
    .profile-avatar{width:72px;height:72px;border-radius:12px;overflow:hidden;flex-shrink:0;border:1px solid #eef2ff;}
    .profile-avatar img{width:100%;height:100%;object-fit:cover}
    .profile-meta{flex:1}
    .profile-meta h3{margin:0;font-size:16px}
    .meta-small{font-size:13px;color:var(--muted);margin-top:6px}

    .card {background:var(--card);border-radius:var(--radius);box-shadow:var(--soft-shadow);padding:16px;}
    .card + .card{margin-top:14px}

    .quick-actions{display:flex;flex-direction:column;gap:10px;margin-top:12px}
    .quick-actions a{display:inline-block;padding:9px 12px;border-radius:8px;border:1px dashed rgba(15,23,42,0.06);color:var(--accent);font-weight:600;text-decoration:none}

    /* Right column */
    .row {display:flex;gap:14px; margin-bottom:14px;}
    .stat {flex:1;background:linear-gradient(180deg,#fff,#fbfdff);padding:14px;border-radius:10px;box-shadow:var(--soft-shadow);display:flex;flex-direction:column;gap:8px}
    .stat .num{font-size:20px;font-weight:700;color:#0b2447}
    .stat .label{font-size:13px;color:var(--muted)}

    /* Upcoming sessions */
    .sessions-table {width:100%;border-collapse:collapse;margin-top:6px}
    .sessions-table th, .sessions-table td {padding:10px 12px;border-bottom:1px solid #eef2ff;text-align:left;font-size:14px}
    .sessions-table thead th {font-size:13px;color:var(--muted);font-weight:600;background:transparent}
    .session-row:hover td{background:#fbfdff}

    .status-pill {display:inline-block;padding:6px 10px;border-radius:999px;font-weight:700;font-size:13px}
    .status-approved{background:#ecfdf5;color:var(--success);border:1px solid rgba(16,163,127,0.08)}
    .status-pending{background:#fff7ed;color:#b45309;border:1px solid rgba(245,158,11,0.07)}
    .status-declined{background:#fff1f2;color:var(--danger);border:1px solid rgba(220,38,38,0.06)}

    /* Notifications dropdown */
    .notif-dropdown{position:absolute;right:0;top:46px;width:360px;background:var(--card);box-shadow:var(--shadow);border-radius:10px;overflow:hidden;display:none;z-index:30}
    .notif-dropdown .note{padding:12px;border-bottom:1px solid #f1f5f9}
    .notif-dropdown .note:last-child{border-bottom:none}
    .note .msg{font-size:14px;color:#0b2447}
    .note .time{font-size:12px;color:var(--muted);margin-top:6px}
    .note.unread{background:linear-gradient(90deg, rgba(37,99,235,0.03), transparent)}

    /* History list */
    .history-list{display:flex;flex-direction:column;gap:8px;margin-top:8px}
    .history-item{display:flex;justify-content:space-between;align-items:center;padding:10px;border-radius:8px;background:#fbfdff;border:1px solid #f1f5f9}
    .history-item .left{font-size:14px}
    .history-item .right{font-size:13px;color:var(--muted)}

    footer{margin-top:22px;color:var(--muted);font-size:13px;text-align:center}
  </style>
</head>
<body>
  <div class="shell">
    <div class="top">
      <div class="brand">
        <div class="logo"><img src="logo.jpg" alt="logo" style="width:100%;height:100%;border-radius:8px;object-fit:cover"></div>
        <div>
          <div class="title">OrientaCore — Student Dashboard</div>
          <div class="subtitle">Welcome back — <?= htmlspecialchars($studentName) ?></div>
        </div>
      </div>

      <div class="actions">
        <div class="notif" id="notifWrap" aria-haspopup="true">
          <i class="fa fa-bell" style="font-size:18px;color:var(--accent)"></i>
          <?php if($unreadCount>0): ?>
            <span class="count" id="notifCount"><?= $unreadCount ?></span>
          <?php endif; ?>
          <div class="notif-dropdown" id="notifDropdown" role="menu" aria-hidden="true">
            <?php if (count($latestNotifications) > 0): ?>
              <?php foreach($latestNotifications as $n): ?>
                <div class="note <?= $n['is_read'] ? '' : 'unread' ?>" data-id="<?= $n['id'] ?>">
                  <div class="msg"><?= htmlspecialchars($n['message']) ?></div>
                  <div class="time"><?= date('M d, Y — H:i', strtotime($n['created_at'])) ?></div>
                </div>
              <?php endforeach; ?>
              <div style="padding:10px;text-align:center"><a href="student_notifications.php">View all notifications</a></div>
            <?php else: ?>
              <div class="note"><div class="msg" style="color:var(--muted)">No notifications</div></div>
            <?php endif; ?>
          </div>
        </div>

        <a class="btn" href="book_session.php"><i class="fa fa-calendar-plus"></i> Book Session</a>
      </div>
    </div>

    <div class="grid">
      <!-- left column -->
      <div>
        <div class="profile-card card">
          <div class="profile-avatar">
            <img src="<?= htmlspecialchars($studentPic) ?>" alt="avatar">
          </div>
          <div class="profile-meta">
            <h3><?= htmlspecialchars($studentName) ?></h3>
            <div class="meta-small"><?= htmlspecialchars($studentEmail) ?></div>
            <div class="meta-small">Reg No: <?= htmlspecialchars($studentReg) ?></div>

            <div class="quick-actions">
              <a href="profile.php">Edit Profile</a>
              <a href="my_results.php">View Results</a>
              <a href="student_notifications.php">Notifications (<?= $unreadCount ?>)</a>
            </div>
          </div>
        </div>

        <div class="card" style="margin-top:14px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <div style="font-weight:700">Recent Assessments</div>
            <a href="my_results.php" class="secondary btn" style="padding:6px 10px;font-weight:600">All results</a>
          </div>

          <?php if ($history): ?>
            <div class="history-list">
              <?php foreach ($history as $h): ?>
                <div class="history-item">
                  <div class="left"><?= htmlspecialchars($h['assessment_type']) ?> — <span style="color:var(--muted)"><?= htmlspecialchars($h['score']) ?></span></div>
                  <div class="right"><?= date('M d, Y', strtotime($h['created_at'])) ?></div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div style="color:var(--muted);padding:8px">No past assessments</div>
          <?php endif; ?>
        </div>
      </div>

      <!-- right column -->
      <div>
        <div style="display:flex;gap:14px;margin-bottom:14px">
          <div class="stat card">
            <div class="num"><?= $totalAssessments ?></div>
            <div class="label">Assessments taken</div>
          </div>
          <div class="stat card">
            <div class="num"><?= $latest ? htmlspecialchars($latest['score']) : '—' ?></div>
            <div class="label">Latest score</div>
          </div>
        </div>

        <div class="card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
            <div style="font-weight:700">Upcoming Sessions</div>
            <a href="my_sessions.php" class="btn secondary" style="padding:8px 12px">View all</a>
          </div>

          <table class="sessions-table">
            <thead>
              <tr>
                <th style="width:36%">Date & time</th>
                <th style="width:22%">Mode</th>
                <th style="width:26%">Counsellor</th>
                <th style="width:16%">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($upcoming): ?>
                <?php foreach($upcoming as $u): 
                  $st = strtolower(trim($u['status'] ?? 'pending'));
                  $pillClass = $st === 'approved' ? 'status-approved' : ($st === 'declined' ? 'status-declined' : 'status-pending');
                ?>
                <tr class="session-row">
                  <td><?= fmt($u['session_date']) ?></td>
                  <td><?= htmlspecialchars($u['mode'] ?: '—') ?></td>
                  <td><?= htmlspecialchars($u['counsellor_name'] ?: 'Unassigned') ?></td>
                  <td><span class="status-pill <?= $pillClass ?>"><?= ucfirst($st) ?></span></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="4" style="text-align:center;padding:14px;color:var(--muted)">No upcoming sessions</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="card" style="margin-top:14px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
            <div style="font-weight:700">Quick Actions</div>
            <div style="font-size:13px;color:var(--muted)">Shortcuts</div>
          </div>
          <div style="display:flex;gap:10px;flex-wrap:wrap">
            <a class="btn" href="book_session.php"><i class="fa fa-calendar-plus"></i> Book Session</a>
            <a class="btn secondary" href="student_career_test.php"><i class="fa fa-vials"></i> Take Career Test</a>
            <a class="btn secondary" href="profile.php"><i class="fa fa-user"></i> Profile</a>
          </div>
        </div>
      </div>
    </div>

    <footer>© <?= date('Y') ?> OrientaCore — Student Portal</footer>
  </div>

<script>
  // notification dropdown + mark read via AJAX
  const notifWrap = document.getElementById('notifWrap');
  const notifDropdown = document.getElementById('notifDropdown');
  const notifCountEl = document.getElementById('notifCount');

  notifWrap.addEventListener('click', (e) => {
    e.stopPropagation();
    notifDropdown.style.display = notifDropdown.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (e) => {
    if (!notifWrap.contains(e.target)) notifDropdown.style.display = 'none';
  });

  // mark notification read when clicked
  document.querySelectorAll('.notif-dropdown .note').forEach(noteEl=>{
    noteEl.addEventListener('click', function(){
      const id = this.getAttribute('data-id');
      if (!id) return;
      // optimistic UI: mark as read visually
      this.classList.remove('unread');
      // reduce count
      if (notifCountEl) {
        let c = parseInt(notifCountEl.textContent || '0', 10);
        if (c > 0) {
          c = c - 1;
          if (c === 0) notifCountEl.remove(); else notifCountEl.textContent = c;
        }
      }

      // send POST to mark read
      fetch('mark_notification_read.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
      }).catch(err => {
        console.error('mark read failed', err);
      });
    });
  });
</script>
</body>
</html>
