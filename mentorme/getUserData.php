<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';

$userData = array();

if (isset($_POST['email'])) {
    $useremail = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc(); 
    } else {
        $userData['error'] = 'User not found';
        http_response_code(404); 
    }
} else {
    $userData['error'] = 'No email provided';
    http_response_code(400);
}

echo json_encode($userData);
?>
