<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';

if (!isset($_POST['user_email'], $_POST['chat_partner_email'])) {
    echo json_encode(['status' => 0, 'message' => 'Missing required parameters']);
    exit;
}

$user_email = $_POST['user_email'];
$chat_partner_email = $_POST['chat_partner_email'];

$sql = "SELECT mkey, message, sender, receiver, timestamp, status, receiverimage, senderimage, audiourl, mediaurl, type 
        FROM messages 
        WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) 
        ORDER BY timestamp ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 0, 'message' => 'SQL error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $user_email, $chat_partner_email, $chat_partner_email, $user_email);

$stmt->execute();
$result = $stmt->get_result();

$messages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode(['status' => 1, 'messages' => $messages]);
} else {
    echo json_encode(['status' => 0, 'message' => 'No messages found']);
}

$stmt->close();
$conn->close();
?>
