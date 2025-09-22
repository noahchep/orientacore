<?php
// view_user.php
session_start();
require_once "db.php";

// check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// get user id from url
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = intval($_GET['id']);

// handle delete
if (isset($_POST['delete'])) {
    $delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $delete->execute([$user_id]);
    header("Location: manage_users.php");
    exit;
}

// fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found!");
}

// handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete'])) {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $role   = $_POST['role'];
    $status = $_POST['status'];

    $update = $pdo->prepare("UPDATE users SET name=?, email=?, role=?, status=? WHERE id=?");
    $update->execute([$name, $email, $role, $status, $user_id]);

    // refresh data
    header("Location: view_user.php?id=" . $user_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View / Edit User - OrientaCore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>View / Edit User</h2>
  <div class="card p-4 shadow-sm">
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          <option value="counsellor" <?= $user['role'] === 'counsellor' ? 'selected' : '' ?>>Counsellor</option>
          <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="pending" <?= $user['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
          <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Save Changes</button>
      <a href="manage_users.php" class="btn btn-secondary">Back</a>
      <button type="submit" name="delete" class="btn btn-danger float-end" onclick="return confirm('Are you sure you want to delete this user?');">Delete User</button>
    </form>
  </div>
</div>
</body>
</html>
