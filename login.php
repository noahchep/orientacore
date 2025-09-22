<?php
require 'db.php'; // Unified PDO connection

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = trim($_POST['reg_no'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($identifier && $password) {
        // Fetch user by reg_no or email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reg_no = :id OR email = :id LIMIT 1");
        $stmt->execute(['id' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check password
            if (password_verify($password, $user['password_hash'])) {
                $status = strtolower(trim($user['status']));
                
                if ($status !== 'active') {
                    $error = "Your account is not active yet. Please wait for admin approval.";
                } else {
                    // Set session variables
                    $_SESSION['user_id']  = $user['id'];
                    $_SESSION['name']     = $user['name'];
                    $_SESSION['role']     = $user['role'];
                    $_SESSION['email']    = $user['email'];
                    $_SESSION['reg_no']   = $user['reg_no'];

                    // Redirect based on role
                    switch ($user['role']) {
                        case 'admin':
                            header("Location: admin_dashboard.php");
                            break;
                        case 'counsellor':
                            header("Location: counsellor_dashboard.php");
                            break;
                        case 'student':
                            header("Location: student_dashboard.php");
                            break;
                        default:
                            $error = "Unknown role assigned.";
                    }
                    exit;
                }
            } else {
                $error = "Invalid registration number/email or password.";
            }
        } else {
            $error = "No account found with that registration number or email.";
        }
    } else {
        $error = "Please enter your login details.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — OrientaCore</title>

  <!-- Google font (optional) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --accent: #3498db;
      --accent-dark: #2980b9;
      --muted: #7f8c8d;
      --bg: #f4f6f9;
      --card-radius: 12px;
    }
    *{box-sizing:border-box}
   body {
    margin: 0;
    font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    color: #20303a;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;

    background: url('back.jpg') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    inset: 0; /* shorthand for top, right, bottom, left = 0 */
    background-color: rgba(0, 0, 0, 0.5); /* black overlay with 50% opacity */
    z-index: 0;
    pointer-events: none;
}


    .login-card{
      position: relative;
      z-index: 2;
      width: 380px;
      max-width: calc(100% - 48px);
      background: #ffffff;
      border-radius: var(--card-radius);
      box-shadow: 0 12px 30px rgba(17,24,39,0.08);
      padding: 28px;
      display:flex;
      flex-direction:column;
      gap:12px;
    }

    .brand { display:flex; gap:12px; align-items:center; margin-bottom:6px; }
    .brand .logo {
      width:60px; height:60px; border-radius:10px; object-fit:cover;
      box-shadow: 0 6px 18px rgba(24, 25, 26, 0.06);
    }
    .brand h2 { margin:0; font-size:18px; color:#22303a; letter-spacing:0.2px; }

    .lead { color:var(--muted); font-size:13px; margin-bottom:6px; }

    form { display:block; margin-top:4px; }
    label { display:block; font-size:13px; color:#34495e; margin-bottom:6px; }
    input[type="text"], input[type="password"] {
      width:100%;
      padding:12px 14px;
      border: 1px solid #e6eef6;
      border-radius:8px;
      font-size:14px;
      outline:none;
      transition: box-shadow .15s ease, border-color .15s ease;
    }
    input:focus { box-shadow: 0 6px 18px rgba(52,152,219,0.06); border-color: var(--accent); }

    .actions { display:flex; gap:10px; margin-top:8px; align-items:center; justify-content:space-between; }

    .btn {
      background: var(--accent);
      color: #fff;
      border: 0;
      padding: 10px 14px;
      border-radius: 8px;
      cursor:pointer;
      font-weight:600;
      transition: transform .12s ease, background .12s ease;
    }
    .btn:hover { background: var(--accent-dark); transform: translateY(-2px); }

    .secondary {
      background: transparent;
      color: var(--muted);
      border: 1px solid #eef3f7;
      padding: 10px 12px;
      border-radius: 8px;
      cursor: pointer;
    }

    .error {
      background: #fff3f3;
      color: #7a1f1f;
      border: 1px solid #ffd6d6;
      padding: 10px 12px;
      border-radius: 8px;
      font-size:13px;
    }

    .foot {
      margin-top:12px;
      font-size:13px;
      color:var(--muted);
      text-align:center;
    }
  </style>
</head>
<body>
  <div class="bg-wrap" aria-hidden="true"></div>

  <main class="login-card">
    <div class="brand">
      <img src="logo.jpg" alt="OrientaCore" class="logo">
      <div>
        <h2>Login — OrientaCore</h2>
        <div class="lead">Enter your Registration No. or Email and Password.</div>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="error" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div>
        <label for="reg_no">Registration No. / Email</label>
        <input id="reg_no" name="reg_no" type="text" required value="<?= isset($_POST['reg_no']) ? htmlspecialchars($_POST['reg_no']) : '' ?>">
      </div>

      <div style="margin-top:8px;">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
      </div>

      <div class="actions">
        <button type="submit" class="btn">Login</button>
        <a href="forgot_password.php" class="secondary" style="text-decoration:none;">Forgot?</a>
      </div>
    </form>

    <div class="foot">
      Don’t have an account? Contact your administrator to be registered.
    </div>
  </main>
</body>
</html>
