<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';

$response = array();

if (isset($_POST['useremail'], $_POST['mentoremail'], $_POST['mentorname'], $_POST['rating'], $_POST['text'])) {
    $useremail = $_POST['useremail'];
    $mentoremail = $_POST['mentoremail'];
    $mentorname = $_POST['mentorname'];
    $rating = floatval($_POST['rating']); 
    $text = $_POST['text'];


    $stmt = $conn->prepare("INSERT INTO reviews (useremail, mentoremail, mentorname, rating, text) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $useremail, $mentoremail, $mentorname, $rating, $text);

    if ($stmt->execute()) {
        $response['message'] = "Review added successfully";
        $response['status'] = 1;
        $response['review_id'] = $conn->insert_id;
    } else {
        $response['message'] = "Failed to add review";
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
