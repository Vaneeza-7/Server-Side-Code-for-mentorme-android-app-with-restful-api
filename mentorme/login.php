<?php
session_start();
include 'conn.php';
$response = array();

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT uid, name FROM `users` WHERE `email` = ? AND `password` = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();


    if ($user)
    {
        session_regenerate_id();
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['name'] = $user['name'];
        // Prepare response
        $response['message'] = "Login successful";
        $response['user'] = ['uid' => $user['uid'], 'name' => $user['name']]; // Only send back necessary data
        $response['status'] = 1;
        echo "1";
    } 
    else
    {
        $response['message'] = "Login failed, wrong password";
        $response['status'] = 0;
        echo "0";   
    }
} 
    else {
    $response['message'] = "Invalid request";
    $response['status'] = -1;
    echo "-1";
}

$conn->close();
?>
