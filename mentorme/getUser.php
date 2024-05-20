<?php
session_start();
include 'conn.php';

$userData = array();

// Check if the user is logged in by checking if 'uid' is set in the session
//if (isset($_SESSION['uid'])) {
  //  $userid = $_SESSION['uid']; // Get user ID from session

  $userid = 1; // Hardcoded user ID for testing purposes
    // Prepare the SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `uid` = ?");
    $stmt->bind_param("i", $userid);
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
// else {
    // If the session does not have 'uid', the user is not logged in
  //  $userData['error'] = 'You are not logged in.';
//}

// Convert the $userData array to JSON format
$jsonUserData = json_encode($userData);
header('Content-Type: application/json');
echo $jsonUserData;
?>
