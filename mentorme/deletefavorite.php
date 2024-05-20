<?php
header('Content-Type: application/json');
include 'conn.php'; 

$response = array();

if (isset($_POST['useremail'], $_POST['mentoremail'])) {
    $useremail = $_POST['useremail'];
    $mentoremail = $_POST['mentoremail'];

    $stmt = $conn->prepare("DELETE FROM favorites WHERE useremail = ? AND mentoremail = ?");
    $stmt->bind_param("ss", $useremail, $mentoremail);
    $success = $stmt->execute();

    if ($success) {
        if ($stmt->affected_rows > 0) {
            $response['message'] = "Favorite successfully deleted";
            $response['status'] = 1;
        } else {
            $response['message'] = "No favorite found to delete";
            $response['status'] = 0;
        }
    } else {
        $response['message'] = "Deletion failed due to an error";
        $response['status'] = 0;
        $response['error'] = $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request - parameters missing";
    $response['status'] = -1;
}

$conn->close();
echo json_encode($response);
?>
