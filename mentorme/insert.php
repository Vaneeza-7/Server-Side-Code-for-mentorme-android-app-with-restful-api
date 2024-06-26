<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conn.php'; 

$response = array();

// Check if the post data is available
if(isset($_POST['email'], $_POST['password'], $_POST['name'], $_POST['phone'], $_POST['country'], $_POST['city'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $dp = ''; 
    $cp = ''; 

    $stmt = $conn->prepare("INSERT INTO `users`(`email`, `password`, `name`, `phone`, `country`, `city`, `dp`, `cp`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $email, $password, $name, $phone, $country, $city, $dp, $cp);
    if($stmt->execute()) {
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
