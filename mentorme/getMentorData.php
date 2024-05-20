<?php
header('Content-Type: application/json');
session_start();
include 'conn.php'; 

$mentorData = array();

if (isset($_POST['email'])) {
    $mentorEmail = $_POST['email'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM `mentors` WHERE `email` = ?");
    $stmt->bind_param("s", $mentorEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    if ($result->num_rows > 0) {
        $mentorData = $result->fetch_assoc();
    } else {
        $mentorData['error'] = 'Mentor not found';
        http_response_code(404); 
    }
} else {
    $mentorData['error'] = 'No email provided';
    http_response_code(400);
}

echo json_encode($mentorData);
?>
