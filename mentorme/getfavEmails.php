<?php
header('Content-Type: application/json');
include 'conn.php'; 

$response = array();

if (isset($_POST['useremail'])) {
    $useremail = $_POST['useremail'];

    $stmt = $conn->prepare("SELECT mentoremail FROM favorites WHERE useremail = ?");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    $mentors = array();
    while ($row = $result->fetch_assoc()) {
        $mentors[] = $row['mentoremail'];
    }

    $stmt->close();
    $conn->close();

    
    echo json_encode(array("status" => 1, "mentors" => $mentors));
} else {
    echo json_encode(array("status" => 0, "message" => "Invalid request"));
}
?>
