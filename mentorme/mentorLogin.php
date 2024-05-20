<?php
session_start();
include 'conn.php'; // Ensure this file contains the correct database connection setup

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT id, name FROM `mentors` WHERE `email` = ? AND `password` = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $mentor = $result->fetch_assoc();
    $stmt->close();

    if ($mentor)
    {
        session_regenerate_id();
        $_SESSION['uid'] = $mentor['id'];
        $_SESSION['name'] = $mentor['name'];
        // Prepare response
        echo "1"; // Login successful
    } 
    else
    {
        echo "0"; // Login failed, wrong password
    }
} 
else {
    echo "-1"; // Invalid request
}

$conn->close();
?>
