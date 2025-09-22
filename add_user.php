<?php
session_start();
require 'db.php'; // your PDO connection

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_no = trim($_POST['reg_no'] ?? '');
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role   = $_POST['role'] ?? 'student';
    $status = $_POST['status'] ?? 'pending';

    if ($reg_no && $name && $email && $password && $role) {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (reg_no, name, email, password_hash, role, status, created_at) VALUES (:reg_no, :name, :email, :password_hash, :role, :status, NOW())");
            $stmt->execute([
                'reg_no' => $reg_no,
                'name' => $name,
                'email' => $email,
                'password_hash' => $password_hash,
                'role' => $role,
                'status' => $status
            ]);
            $success = "User added successfully!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                $error = "Registration number or email already exists.";
            } else {
                $error = "Error: " . $e->getMessage();
            }
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add User — OrientaCore</title>
<style>
body { font-family: Arial, sans-serif; background:#f4f6f9; padding:20px; }
form { background:white; padding:20px; border-radius:10px; max-width:400px; margin:auto; }
input, select { width:100%; padding:10px; margin:6px 0 12px; border-radius:6px; border:1px solid #ccc; }
button { padding:10px 14px; background:#3498db; color:white; border:none; border-radius:6px; cursor:pointer; }
button:hover { background:#2980b9; }
.error { background:#ffd6d6; color:#7a1f1f; padding:10px; border-radius:6px; margin-bottom:12px; }
.success { background:#d6ffd6; color:#1f7a1f; padding:10px; border-radius:6px; margin-bottom:12px; }
</style>
</head>
<body>

<h2 style="text-align:center;">Add New User</h2>

<?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post">
    <label for="reg_no">Registration No</label>
    <input type="text" name="reg_no" id="reg_no" required>

    <label for="name">Full Name</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <label for="role">Role</label>
    <select name="role" id="role" required>
        <option value="student">Student</option>
        <option value="counsellor">Counsellor</option>
        <option value="admin">Admin</option>
    </select>

    <label for="status">Status</label>
    <select name="status" id="status" required>
        <option value="active">Active</option>
        <option value="pending" selected>Pending</option>
    </select>

    <button type="submit">Add User</button>
</form>

</body>
</html>
