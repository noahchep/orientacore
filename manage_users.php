<?php
// manage_users.php
session_start();
require_once "db.php";

// Only allow admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle actions (approve, reject, activate, deactivate)
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int) $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'approved' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'reject') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'activate') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'deactivate') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: manage_users.php");
    exit;
}

// Search & filter
$filter_role = $_GET['role'] ?? '';
$filter_status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM users WHERE 1=1";
$params = [];

if ($filter_role) {
    $sql .= " AND role = ?";
    $params[] = $filter_role;
}
if ($filter_status) {
    $sql .= " AND status = ?";
    $params[] = $filter_status;
}
if ($search) {
    $sql .= " AND (name LIKE ? OR reg_no LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Manage Users</h2>

    <!-- Filter Form -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by name, reg no, email" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="admin" <?= $filter_role==='admin'?'selected':'' ?>>Admin</option>
                <option value="counsellor" <?= $filter_role==='counsellor'?'selected':'' ?>>Counsellor</option>
                <option value="student" <?= $filter_role==='student'?'selected':'' ?>>Student</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="pending" <?= $filter_status==='pending'?'selected':'' ?>>Pending</option>
                <option value="approved" <?= $filter_status==='approved'?'selected':'' ?>>Approved</option>
                <option value="rejected" <?= $filter_status==='rejected'?'selected':'' ?>>Rejected</option>
                <option value="active" <?= $filter_status==='active'?'selected':'' ?>>Active</option>
                <option value="inactive" <?= $filter_status==='inactive'?'selected':'' ?>>Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- Users Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Reg No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($users): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['reg_no']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><span class="badge bg-<?= $user['status']==='approved' || $user['status']==='active' ? 'success':'secondary' ?>">
                        <?= htmlspecialchars($user['status']) ?>
                    </span></td>
                    <td>
                        <?php if ($user['status'] === 'pending'): ?>
                            <a href="?action=approve&id=<?= $user['id'] ?>" class="btn btn-sm btn-success">Approve</a>
                            <a href="?action=reject&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger">Reject</a>
                        <?php elseif ($user['status'] === 'approved' || $user['status'] === 'active'): ?>
                            <a href="?action=deactivate&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Deactivate</a>
                        <?php elseif ($user['status'] === 'inactive' || $user['status'] === 'rejected'): ?>
                            <a href="?action=activate&id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Activate</a>
                        <?php endif; ?>
                        <a href="view_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No users found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
