<?php
header('Content-Type: application/json');
include 'conn.php'; 

$response = array();

if (isset($_POST['useremail'], $_POST['mentoremail'])) {
    $useremail = $_POST['useremail'];
    $mentoremail = $_POST['mentoremail'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id FROM favorites WHERE useremail = ? AND mentoremail = ?");
    $stmt->bind_param("ss", $useremail, $mentoremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    // Check if any rows returned
    if ($result->num_rows > 0) {
        $response['favorited'] = true;  
        $response['status'] = 1;
    } else {
        $response['favorited'] = false; 
        $response['status'] = 1;
    }
} else {
    $response['message'] = "Invalid request";
    $response['status'] = -1;
}

echo json_encode($response);
?>
