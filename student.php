<?php
session_start();
require 'db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch all students
try {
    $stmt = $pdo->prepare("SELECT id, name, reg_no, email, role, status, created_at FROM users WHERE role = 'student'");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
body {
    font-family: 'Inter', sans-serif;
    background: #eef2f7;
    margin: 0;
    padding: 20px;
    color: #333;
}

h1 {
    margin-bottom: 20px;
    font-weight: 600;
    color: #1e3c72;
}

.breadcrumb {
    margin-bottom: 20px;
    font-size: 14px;
    color: #555;
}
.breadcrumb span:last-child {
    font-weight: 600;
    color: #1e3c72;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.add-btn {
    padding: 10px 18px;
    background: linear-gradient(90deg, #28a745, #218838);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}
.add-btn:hover {
    background: linear-gradient(90deg, #218838, #19692c);
    transform: translateY(-2px);
}

#search {
    width: 300px;
    padding: 8px 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}
#search:focus {
    border-color: #1e3c72;
    box-shadow: 0 0 5px rgba(30,60,114,0.2);
    outline: none;
}

.table-container {
    overflow-x: auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

table {
    border-collapse: collapse;
    width: 100%;
    min-width: 750px;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 14px 16px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
    font-size: 15px;
}

th {
    background: linear-gradient(90deg, #1976d2, #2196f3);
    color: white;
    font-weight: 600;
    text-align: left;
}

tr:nth-child(even) td {
    background: #f9fbff;
}

tr:hover td {
    background: #e3f2fd;
    transition: 0.2s;
}

.actions-cell {
    min-width: 500px;
    white-space: nowrap;
}

.actions-cell .action-btn {
    display: inline-flex;
    margin-right: 6px;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.edit { background: #007bff; color: #fff; }
.edit:hover { background: #0056d2; transform: translateY(-1px); }

.delete { background: #dc3545; color: #fff; }
.delete:hover { background: #b21f2d; transform: translateY(-1px); }

.view { background: #17a2b8; color: #fff; }
.view:hover { background: #117a8b; transform: translateY(-1px); }

.report { background: #6f42c1; color: #fff; }
.report:hover { background: #563d7c; transform: translateY(-1px); }

.tag {
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    color: white;
}

.tag-active { background: #28a745; }
.tag-inactive { background: #dc3545; }

@media (max-width: 768px) {
    .table-container { padding: 15px; }
    #search { width: 100%; }
    .actions-cell { display: flex; flex-wrap: wrap; gap: 5px; }
}
</style>

</head>
<body>
    <div class="breadcrumb">
        <span>Dashboard</span> &gt; <span>Students</span>
    </div>

    <div class="top-bar">
        <h1>Student Management</h1>
        <a class="add-btn" href="add_student.php"><i class="fa fa-plus"></i> Add New Student</a>
    </div>

    <input type="text" id="search" placeholder="Search students..." onkeyup="filterTable()">

    <div class="table-container">
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Reg No</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)): ?>
                    <?php foreach($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['reg_no']) ?></td>
                            <td><?= htmlspecialchars($student['email']) ?></td>
                            <td>
                                <span class="tag <?= $student['status']==='active'?'tag-active':'tag-inactive' ?>">
                                    <?= ucfirst($student['status']) ?>
                                </span>
                            </td>
                            <td><?= date("d M Y, H:i", strtotime($student['created_at'])) ?></td>
                            
                            <td class="actions-cell">
                                <a class="action-btn edit" href="edit_student.php?id=<?= $student['id'] ?>">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a class="action-btn delete" href="delete_student.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                                <a class="action-btn view" href="view_performance.php?student_id=<?= $student['id'] ?>">
                                    <i class="fa fa-chart-line"></i> Performance
                                </a>
                                <a class="action-btn view" href="view_sessions.php?student_id=<?= $student['id'] ?>">
                                    <i class="fa fa-eye"></i> Sessions
                                </a>
                                <a class="action-btn report" href="admin_view_report.php?student_name=<?= urlencode($student['name']) ?>">
    <i class="fa fa-file-alt"></i> View Reports
</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function filterTable() {
            let input = document.getElementById('search').value.toLowerCase();
            let table = document.getElementById('studentsTable');
            let rows = table.getElementsByTagName('tr');
            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let match = false;
                for (let j = 0; j < 2; j++) {
                    if (cells[j] && cells[j].innerText.toLowerCase().indexOf(input) > -1) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? '' : 'none';
            }
        }
    </script>
</body>
</html>
