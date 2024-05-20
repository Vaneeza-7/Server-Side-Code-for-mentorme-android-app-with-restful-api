<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';  

$response = array();

if (isset($_POST['useremail'], $_POST['mentoremail'], $_POST['mentorname'], $_POST['date'], $_POST['time'], $_POST['price'], $_POST['mentorimage'])) {
    $useremail = $_POST['useremail'];
    $mentoremail = $_POST['mentoremail'];
    $mentorname = $_POST['mentorname'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $mentorimage = $_POST['mentorimage'];

    
    $stmt = $conn->prepare("INSERT INTO bookings (useremail, mentoremail, mentorname, date, time, price, mentorimage) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $useremail, $mentoremail, $mentorname, $date, $time, $price, $mentorimage);

    if ($stmt->execute()) {
        $response['message'] = "Booking added successfully";
        $response['status'] = 1;
        $response['booking_id'] = $conn->insert_id;
    } else {
        $response['message'] = "Failed to add booking";
        $response['status'] = 0;
        $response['error'] = $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request";
    $response['status'] = -1;
}

$conn->close();

echo json_encode($response);
?>
