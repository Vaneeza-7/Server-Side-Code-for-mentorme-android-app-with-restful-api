<?php
header('Content-Type: application/json');
session_start();
include 'conn.php';

$mentorData = array();

$stmt = $conn->prepare("SELECT * FROM mentors");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mentorData[] = $row;
    }
    echo json_encode($mentorData); 
} else {
    
    echo json_encode([]);
}
?>
