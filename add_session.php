<?php
// add_session.php
require 'db.php';

if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    die("Student ID not provided.");
}

$student_id = intval($_GET['student_id']);
$message = "";

try {
    // Fetch student details with approval check
    $stmt = $pdo->prepare("SELECT id, reg_no, name, status FROM users WHERE id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }

    
 // 🚫 Restrict if student is not approved
$studentStatus = strtolower(trim($student['status']));

if (!in_array($studentStatus, ['approved', '1', 'yes', 'active'])) {
    die("⚠️ This student is not approved. You cannot add a session.");
}


    // Fetch counsellors for dropdown
    $counsellors = $pdo->query("SELECT id, name FROM users WHERE role = 'counsellor' ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $session_date  = $_POST['session_date'] ?? '';
        $mode          = $_POST['mode'] ?? '';
        $counsellor_id = $_POST['counsellor_id'] ?? '';
        $notes         = $_POST['notes'] ?? '';
        $action_plan   = $_POST['action_plan'] ?? '';
        $status        = $_POST['status'] ?? 'Pending';

        if (!empty($session_date) && !empty($mode) && !empty($counsellor_id)) {
            $stmt = $pdo->prepare("INSERT INTO sessions 
                (student_id, counsellor_id, session_date, mode, notes, action_plan, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$student_id, $counsellor_id, $session_date, $mode, $notes, $action_plan, $status]);

            header("Location: sessions.php?student_id=" . $student_id);
            exit;
        } else {
            $message = "⚠️ Please fill in all required fields.";
        }
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      /* ===== Page base ===== */
      :root{
        --brand-1: #2563eb; /* blue */
        --brand-2: #06b6d4; /* teal */
        --accent:   #10b981; /* green */
        --muted: #667085;
        --card-bg: #ffffff;
      }
      html,body{height:100%;}
      body{
        font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: linear-gradient(180deg, #f6fbff 0%, #f4f6f8 100%);
        color: #0f172a;
        -webkit-font-smoothing:antialiased;
        padding: 28px;
      }

      /* Container sizing */
      .container.mt-4{
        max-width: 920px;
        margin-top: 34px;
      }

      /* Card */
      .card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(16,24,40,0.06);
      }

      /* Card header - gradient */
      .card-header {
        background: linear-gradient(90deg, var(--brand-1), var(--brand-2));
        color: #fff;
        display:flex;
        gap: 12px;
        align-items:center;
        justify-content:space-between;
        padding: 18px 20px;
      }
      .card-header h5 {
        margin: 0;
        font-weight: 600;
        letter-spacing: 0.2px;
        font-size: 1.05rem;
      }
      /* If header content wraps on small screens */
      @media (max-width:576px){
        .card-header { flex-direction: column; align-items:flex-start; gap: 8px; }
      }

      /* Card body */
      .card-body { padding: 22px; background: var(--card-bg); }

      /* Form labels and controls */
      .form-label {
        font-weight: 600;
        color: #0f172a;
      }
      .form-control, .form-select, textarea.form-control {
        border-radius: 10px;
        border: 1px solid #e6edf3;
        padding: 10px 12px;
        box-shadow: none;
        transition: border-color .15s ease, box-shadow .15s ease;
        background: #fff;
      }
      .form-control:focus, .form-select:focus, textarea.form-control:focus {
        border-color: rgba(37,99,235,0.9);
        box-shadow: 0 6px 18px rgba(37,99,235,0.06);
        outline: none;
      }

      /* Buttons */
      .btn-success {
        background: linear-gradient(90deg, #12b76a, #0ea5a3);
        border: 0;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(16,185,129,0.12);
      }
      .btn-success:hover { filter: brightness(.95); }
      .btn-secondary {
        border-radius: 10px;
        border: 1px solid #e6e9ef;
        background: #f8fafc;
        color: #0f172a;
      }

      /* Alerts */
      .alert-danger {
        background: #fff5f5;
        color: #742a2a;
        border: 1px solid #ffd6d6;
        border-left: 4px solid #dc2626;
        font-weight: 600;
        padding: 12px 14px;
        border-radius: 8px;
      }

      /* Small helper text */
      .muted-note {
        font-size: 13px;
        color: var(--muted);
        margin-top: 8px;
      }

      /* compact spacing on small screens */
      @media (max-width:480px){
        .card-body { padding: 14px; }
        .card-header { padding: 14px; }
        .form-control, .form-select, textarea.form-control { padding: 8px 10px; }
      }

    </style>
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add Session for <?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['reg_no']) ?>)</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($message)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Session Date *</label>
                    <input type="datetime-local" name="session_date" class="form-control" required>
                    <div class="muted-note">Pick local date & time for the session.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mode *</label>
                    <select name="mode" class="form-select" required>
                        <option value="">-- Select Mode --</option>
                        <option value="In-Person">In-Person</option>
                        <option value="Online">Online</option>
                        <option value="Phone">Phone</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Counsellor *</label>
                    <select name="counsellor_id" class="form-select" required>
                        <option value="">-- Select Counsellor --</option>
                        <?php foreach ($counsellors as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Action Plan</label>
                    <textarea name="action_plan" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Save Session</button>
                <a href="sessions.php?student_id=<?= $student['id'] ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
