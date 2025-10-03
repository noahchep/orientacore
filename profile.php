<?php
session_start();
require 'db.php'; // your PDO connection

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = $error = "";

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Define upload directory
$uploadDir = 'uploads/';
// Create folder if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// --- Handle profile picture upload ---
if (isset($_POST['upload_pic']) && isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        $newName = $uploadDir . uniqid() . '.' . $ext;

        if (move_uploaded_file($file['tmp_name'], $newName)) {
            // Delete old picture if exists
            if (!empty($user['profile_pic']) && file_exists($user['profile_pic'])) {
                unlink($user['profile_pic']);
            }

            // Update database
            $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->execute([$newName, $user_id]);
            $success = "Profile picture updated successfully!";
        } else {
            $error = "Failed to upload image. Please check folder permissions.";
        }
    } else {
        $error = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
    }
}

// --- Handle password change ---
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // Check if password field exists and is hashed
    $storedPassword = $user['password'] ?? '';
    $isHashed = password_get_info($storedPassword)['algo'] !== 0;

    // If hashed, verify normally; else fallback to plain-text comparison
    if (($isHashed && password_verify($current, $storedPassword)) ||
        (!$isHashed && $current === $storedPassword)) {
        if ($new === $confirm) {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed, $user_id]);
            $success = "Password changed successfully!";
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profile Settings</title>
<style>
/* Reset */
* { box-sizing: border-box; margin: 0; padding: 0; }

/* Body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    display: flex;
    justify-content: center;
    padding: 50px 20px;
}

/* Container */
.container {
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Heading */
.container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

/* Messages */
.success {
    color: #2ecc71;
    margin-bottom: 15px;
    text-align: center;
}
.error {
    color: #e74c3c;
    margin-bottom: 15px;
    text-align: center;
}

/* Forms */
form {
    display: flex;
    flex-direction: column;
    margin-bottom: 30px;
}

/* Inputs */
input[type="password"],
input[type="file"] {
    padding: 12px 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
}

/* Buttons */
button {
    padding: 12px 15px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #2980b9;
}

/* Profile Image */
img#preview {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 15px;
    border: 3px solid #3498db;
    align-self: center;
}

/* Form headings */
form h3 {
    margin-bottom: 10px;
    color: #555;
    text-align: center;
}
</style>
</head>
<body>

<div class="container">
    <h2>Profile Settings</h2>

    <?php if($success) echo "<p class='success'>$success</p>"; ?>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <!-- Change Password Form -->
    <form method="post">
        <h3>Change Password</h3>
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit" name="change_password">Change Password</button>
    </form>

    <!-- Profile Picture Form -->
    <form method="post" enctype="multipart/form-data">
        <h3>Update Profile Picture</h3>
        <?php if(!empty($user['profile_pic']) && file_exists($user['profile_pic'])): ?>
            <img id="preview" src="<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile">
        <?php else: ?>
            <img id="preview" src="default.png" alt="Profile">
        <?php endif; ?>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>
        <button type="submit" name="upload_pic">Upload Picture</button>
    </form>
</div>

<script>
// Live preview for profile picture
const profileInput = document.getElementById('profile_pic');
const preview = document.getElementById('preview');

profileInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>
