<?php
header('Content-Type: application/json');
session_start();
include 'conn.php'; 

if (!isset($_POST['mkey'], $_POST['message'])) {
    echo json_encode(['status' => 0, 'message' => 'Missing required parameters']);
    exit;
}

$mkey = $_POST['mkey'];
$newMessage = $_POST['message'];

$sql = "UPDATE messages SET message = ? WHERE mkey = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 0, 'message' => 'SQL error: ' . $conn->error]);
    exit;
}


$stmt->bind_param("ss", $newMessage, $mkey);
if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 1, 'message' => 'Message updated successfully']);
    } else {
        echo json_encode(['status' => 0, 'message' => 'No changes made or message not found']);
    }
} else {
    echo json_encode(['status' => 0, 'message' => 'Update failed: ' . $stmt->error]);
}


$stmt->close();
$conn->close();
?>
