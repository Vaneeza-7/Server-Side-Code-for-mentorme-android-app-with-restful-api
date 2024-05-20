<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';

if (!isset($_POST['mkey'], $_POST['message'], $_POST['sender'], $_POST['receiver'], $_POST['status'], $_POST['receiverimage'], $_POST['audiourl'], $_POST['mediaurl'], $_POST['type'])) {
    echo json_encode(['status' => 0, 'message' => 'Missing required fields']);
    exit;
}

$mkey = $_POST['mkey'];
$message = $_POST['message'];
$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$status = $_POST['status'];
$receiverimage = $_POST['receiverimage'];
$audiourl = $_POST['audiourl'];
$mediaurl = $_POST['mediaurl'];
$type = $_POST['type'];

$sqlImage = "SELECT dp AS senderimage FROM mentors WHERE email = ? UNION SELECT dp AS senderimage FROM users WHERE email = ?";
$stmtImage = $conn->prepare($sqlImage);
if (!$stmtImage) {
    echo json_encode(['status' => 0, 'message' => 'SQL error: ' . $conn->error]);
    exit;
}

$stmtImage->bind_param("ss", $sender, $sender);
$stmtImage->execute();
$resultImage = $stmtImage->get_result();
$senderimage = $resultImage->fetch_assoc()['senderimage'] ?? 'default_image_path.jpg';

$stmtImage->close();

$sql = "INSERT INTO messages (mkey, message, sender, receiver, status, receiverimage, senderimage, audiourl, mediaurl, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 0, 'message' => 'SQL error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssssssssss", $mkey, $message, $sender, $receiver, $status, $receiverimage, $senderimage, $audiourl, $mediaurl, $type);
if ($stmt->execute()) {
    echo json_encode(['status' => 1, 'message' => 'Message inserted successfully']);
} else {
    echo json_encode(['status' => 0, 'message' => 'Insert failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
