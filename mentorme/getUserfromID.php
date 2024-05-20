<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';

$userData = array();


if (isset($_POST['email'])) {
    $useremail = $_POST['email']; 

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param("i", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userData['name'] = $row['name']; // Use actual name from the database
    } else {
        $userData['error'] = 'User not found';
    }
} else {
    // If the POST does not have 'userid', it's a bad request
    $userData['error'] = 'No user ID provided';
    http_response_code(400); // Set HTTP response code to 400 for bad request
}

echo json_encode($userData);
?>
