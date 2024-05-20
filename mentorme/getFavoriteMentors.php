<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';  

if (!isset($_POST['useremail'])) {
    echo json_encode(['status' => 0, 'message' => 'User email is required']);
    exit;
}

$useremail = $_POST['useremail'];

$sql = "SELECT m.* FROM mentors AS m 
        INNER JOIN favorites AS f ON m.email = f.mentoremail 
        WHERE f.useremail = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 0, 'message' => 'SQL error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $useremail);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();

$mentorData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mentorData[] = $row;
    }
    echo json_encode(['status' => 1, 'mentors' => $mentorData]);
} else {
    echo json_encode(['status' => 0, 'message' => 'No favorite mentors found']);
}
?>
