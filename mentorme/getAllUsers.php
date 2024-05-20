<?php
header('Content-Type: application/json');
session_start();
include 'conn.php'; 

$sql = "SELECT uid, email, name, phone, country, city, dp, cp FROM users"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = [];
    
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode(['status' => 1, 'users' => $users]);
} else {
    echo json_encode(['status' => 0, 'message' => 'No users found']);
}

$conn->close();
?>
