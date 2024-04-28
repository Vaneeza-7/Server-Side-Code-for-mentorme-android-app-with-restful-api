<?php
include 'conn.php'; 

$response = array();

// Check if the post data is available
if(isset($_POST['uid'], $_POST['email'], $_POST['name'], $_POST['phone'], $_POST['country'], $_POST['city'])) {
    $uid = $_POST['uid'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $dp = ''; 
    $cp = ''; 

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO `users`(`uid`, `email`, `name`, `phone`, `country`, `city`, `dp`, `cp`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $uid, $email, $name, $phone, $country, $city, $dp, $cp);

    if($stmt->execute()) {
        $response['message'] = "Data inserted successfully";
        $response['id'] = mysqli_insert_id($conn);
        $response['status'] = 1;
        echo "Data inserted successfully";
    } else {
        $response['message'] = "Data insertion failed";
        $response['id'] = 0;
        $response['status'] = 0;
        echo "Data insertion failed";
    }
    $stmt->close();
} else {
    $response['message'] = "Invalid request";
    $response['id'] = 0;
    $response['status'] = 0;
    echo "Invalid request";
}

echo json_encode($response);
?>
