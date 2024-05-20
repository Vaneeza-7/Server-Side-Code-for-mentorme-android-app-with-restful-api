<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conn.php';

$response = array();

// Check if the post data is available
if(isset($_POST['email'], $_POST['password'], $_POST['name'], $_POST['role'], $_POST['description'], $_POST['price'], $_POST['status'], $_POST['category'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $video = '';
    $dp = ''; 
    $cp = ''; 

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO `mentors` (email, password, name, role, description, price, status, category, video, dp, cp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $email, $password, $name, $role, $description, $price, $status, $category, $video, $dp, $cp);

    if ($stmt->execute()) {
        $response['message'] = "Data inserted successfully";
        $response['id'] = mysqli_insert_id($conn);
        $response['status'] = 1;
    } else {
        $response['message'] = "Data insertion failed";
        $response['id'] = 0;
        $response['status'] = 0;
    }
    $stmt->close();
} else {
    $response['message'] = "Invalid request";
    $response['id'] = 0;
    $response['status'] = 0;
}

echo json_encode($response);
?>
