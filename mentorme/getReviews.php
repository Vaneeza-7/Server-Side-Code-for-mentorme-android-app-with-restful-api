<?php
header('Content-Type: application/json');
include 'conn.php';  

$response = array();

if (isset($_POST['useremail'])) {
    $useremail = $_POST['useremail'];

    $stmt = $conn->prepare("SELECT * FROM reviews WHERE useremail = ?");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reviews = array();
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        $response['status'] = 1;
        $response['reviews'] = $reviews;
    } else {
        $response['status'] = 0;
        $response['message'] = "No reviews found for this user";
    }

    $stmt->close();
} else {
    $response['status'] = -1;
    $response['message'] = "Invalid request: useremail not provided";
}

$conn->close();

echo json_encode($response);
?>
