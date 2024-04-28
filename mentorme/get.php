<?php
include 'conn.php';
$response = array();
$response['students'] = array();

$query = "SELECT * FROM `students` order by `students`.`name` ASC";
$res = mysqli_query($conn, $query);

if($res) {
    $response['status'] = 1;
    while($row = mysqli_fetch_assoc($res)) {
        $student = array();
        $student['id'] = $row['id'];
        $student['name'] = $row['name'];
        $student['phone'] = $row['phone'];
        $student['email'] = $row['email'];
        array_push($response['students'], $student);
    }
} else {
    $response['message'] = "Data retrieval failed";
    $response['status'] = 0;
}

// Make sure to use json_encode to output the $response
echo json_encode($response);
?>
