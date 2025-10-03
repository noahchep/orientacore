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
        body { font-family: 'Inter', sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        h1 { margin-bottom: 20px; font-weight: 600; }
        .breadcrumb { margin-bottom: 20px; font-size: 14px; color: #555; }
        .breadcrumb span:last-child { font-weight: 600; color: #000; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .add-btn { padding: 8px 15px; background: #28a745; color: white; border-radius: 5px; text-decoration: none; font-weight: 500; }
        .add-btn:hover { background: #218838; }
        .table-container { overflow-x: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        table { border-collapse: collapse; width: 100%; min-width: 750px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background-color: #f8f9fa; font-weight: 600; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f3f5; transition: 0.2s; }

        /* ✅ Keep action buttons in one line */
        th:nth-child(6), td.actions-cell {
            min-width: 420px;   /* expand Actions column */
            white-space: nowrap; /* prevent wrapping */
        }
        .actions-cell .action-btn {
            display: inline-flex;
            margin-right: 6px;
        }

        .action-btn { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: 5px; color: white; font-size: 13px; text-decoration: none; }
        .edit { background: #007bff; }
        .edit:hover { background: #0069d9; }
        .delete { background: #dc3545; }
        .delete:hover { background: #c82333; }
        .view { background: #17a2b8; }
        .view:hover { background: #138496; }
        .tag { padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; color: white; }
        .tag-active { background: #28a745; }
        .tag-inactive { background: #dc3545; }
        #search { width: 300px; padding: 7px 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc; }
        @media (max-width: 768px) {
            .table-container { padding: 10px; }
            #search { width: 100%; }
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
                    <th>Responses</th>
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
                            
                            <!-- ✅ Actions in one line -->
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
                            </td>

                            <!-- ✅ Responses in its own column -->
                            <td>
                                <a class="action-btn view" href="response.php?student_id=<?= $student['id'] ?>">
                                    <i class="fa fa-file-alt"></i> View Responses
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <script>
        // Simple search filter
        function filterTable() {
            let input = document.getElementById('search').value.toLowerCase();
            let table = document.getElementById('studentsTable');
            let rows = table.getElementsByTagName('tr');
            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let match = false;
                for (let j = 0; j < 2; j++) { // search only Name and Reg No
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
