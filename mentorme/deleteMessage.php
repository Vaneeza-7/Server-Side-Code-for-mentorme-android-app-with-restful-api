<?php
header('Content-Type: application/json');
session_start();
include 'conn.php'; 

if (!isset($_POST['mkey'])) {
    echo json_encode(['status' => 0, 'message' => 'Missing mkey parameter']);
    exit;
}

$mkey = $_POST['mkey'];

$sql = "DELETE FROM messages WHERE mkey = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 0, 'message' => 'SQL error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $mkey);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 1, 'message' => 'Message deleted successfully']);
    } else {
        echo json_encode(['status' => 0, 'message' => 'No message found with the provided mkey']);
    }
} else {
    echo json_encode(['status' => 0, 'message' => 'Deletion failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
