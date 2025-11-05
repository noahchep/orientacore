<?php
session_start();
require 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Ensure counsellor is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'counsellor') {
    header("Location: login.php");
    exit;
}

$counsellor_id = $_SESSION['user_id'];

// Ensure session ID is provided
if (!isset($_GET['id']) && !isset($_POST['id'])) {
    die("Session ID missing.");
}

$session_id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['id']);

// Fetch session and student details
$stmt = $pdo->prepare("
    SELECT s.*, u.name AS student_name, u.email AS student_email
    FROM sessions s
    JOIN users u ON s.student_id = u.id
    WHERE s.id = ? AND s.counsellor_id = ?
");
$stmt->execute([$session_id, $counsellor_id]);
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session) {
    die("Session not found or not assigned to you.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $session_mode = $_POST['session_mode'] ?? '';
    $venue = $_POST['venue'] ?? null;
    $meeting_link = $_POST['meeting_link'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $whatsapp_link = $_POST['whatsapp_link'] ?? null;
    $additional_info = $_POST['additional_info'] ?? null;

    $update = $pdo->prepare("
        UPDATE sessions SET 
            status='approved',
            session_mode=?, 
            venue=?, 
            meeting_link=?, 
            phone_number=?, 
            whatsapp_link=?, 
            additional_info=?, 
            updated_at=NOW()
        WHERE id=? AND counsellor_id=?
    ");
    $update->execute([$session_mode, $venue, $meeting_link, $phone_number, $whatsapp_link, $additional_info, $session_id, $counsellor_id]);

    // Send Email
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noahchepkonga1@gmail.com';  // <-- CHANGE THIS
        $mail->Password   = 'otad ozry cxdm hdfx';     // <-- CHANGE THIS
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('noahchepkonga1@gmail.com', 'Counselling Department');
        $mail->addAddress($session['student_email'], $session['student_name']);

        $mail->isHTML(true);
        $mail->Subject = "Counselling Session Approved";

        $details = "
            <b>Session Mode:</b> $session_mode<br>
        ";

        if ($session_mode === "Physical") $details .= "<b>Venue:</b> $venue<br>";
        if ($session_mode === "Online") $details .= "<b>Meeting Link:</b> $meeting_link<br>";
        if ($session_mode === "Phone") $details .= "<b>Phone Number:</b> $phone_number<br>";
        if ($session_mode === "WhatsApp") $details .= "<b>WhatsApp Link:</b> $whatsapp_link<br>";

        if ($additional_info) $details .= "<br><b>Additional Information:</b><br>$additional_info<br>";

        $mail->Body = "
            Hello <b>{$session['student_name']}</b>,<br><br>
            Your counselling session has been <b>approved</b>.<br><br>
            <b>Session Date:</b> {$session['session_date']}<br><br>
            $details
            <br>Please be on time.<br><br>
            Regards,<br>
            <b>Counselling Department</b>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
    }

    $_SESSION['msg'] = "Session approved and student notified.";
    header("Location: counsellor_view_sessions.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Approve Session</title>
<style>
body { font-family: Arial; margin: 30px; }
label { font-weight: bold; display:block; margin-top:12px; }
input, textarea, select { width:100%; padding:8px; margin-top:6px; }
button { margin-top:18px; padding:10px 15px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer; }
</style>
<script>
function toggleFields(mode) {
    document.getElementById('venue_section').style.display = (mode === 'Physical') ? 'block' : 'none';
    document.getElementById('meeting_section').style.display = (mode === 'Online') ? 'block' : 'none';
    document.getElementById('phone_section').style.display = (mode === 'Phone') ? 'block' : 'none';
    document.getElementById('whatsapp_section').style.display = (mode === 'WhatsApp') ? 'block' : 'none';
}
</script>
</head>
<body>

<h2>Approve Session for <?= htmlspecialchars($session['student_name']) ?></h2>

<form method="post">
<input type="hidden" name="id" value="<?= $session_id ?>">

<label>Session Mode</label>
<input type="radio" name="session_mode" value="Physical" onclick="toggleFields('Physical')" required> Physical
<input type="radio" name="session_mode" value="Online" onclick="toggleFields('Online')" required> Online
<input type="radio" name="session_mode" value="Phone" onclick="toggleFields('Phone')" required> Phone Call
<input type="radio" name="session_mode" value="WhatsApp" onclick="toggleFields('WhatsApp')" required> WhatsApp

<div id="venue_section" style="display:none;">
<label>Venue</label>
<input type="text" name="venue">
</div>

<div id="meeting_section" style="display:none;">
<label>Meeting Link (Zoom / Teams)</label>
<input type="text" name="meeting_link">
</div>

<div id="phone_section" style="display:none;">
<label>Phone Number</label>
<input type="text" name="phone_number">
</div>

<div id="whatsapp_section" style="display:none;">
<label>WhatsApp Link</label>
<input type="text" name="whatsapp_link">
</div>

<label>Additional Information (Optional)</label>
<textarea name="additional_info" rows="3"></textarea>

<button type="submit">Approve Session</button>
</form>

</body>
</html>
