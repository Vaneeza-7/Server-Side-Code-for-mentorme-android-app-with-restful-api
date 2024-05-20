<?php
header('Content-Type: application/json');
include 'conn.php';  

$response = array();

if (isset($_POST['useremail'], $_POST['mentoremail'])) {
    $useremail = $_POST['useremail'];
    $mentoremail = $_POST['mentoremail'];

    // Check if the favorite already exists
    $checkStmt = $conn->prepare("SELECT id FROM favorites WHERE useremail = ? AND mentoremail = ?");
    $checkStmt->bind_param("ss", $useremail, $mentoremail);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkStmt->close();

    if ($checkResult->num_rows > 0) {
        $response['message'] = "This favorite already exists";
        $response['status'] = 0;
    } else {
        // Insert new favorite
        $stmt = $conn->prepare("INSERT INTO favorites (useremail, mentoremail) VALUES (?, ?)");
        $stmt->bind_param("ss", $useremail, $mentoremail);

        if ($stmt->execute()) {
            $response['message'] = "Favorite added successfully";
            $response['status'] = 1;
            $response['favorite_id'] = $conn->insert_id; // Auto-generated ID
        } else {
            $response['message'] = "Failed to add favorite";
            $response['status'] = 0;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    }
} else {
    $response['message'] = "Invalid request";
    $response['status'] = -1;
}

$conn->close();
echo json_encode($response);
?>
