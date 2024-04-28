<?php
include 'conn.php'; 
$response = array();

if(isset($_POST['image']))
{
    $image = $_POST['image'];
    $name = "image_" . time() . ".jpeg"; 
    $path = "images/$name";
    file_put_contents($path, base64_decode($image)); 
    $response['url'] = "smd24a/$path"; 
    $response['message'] = "Image uploaded successfully";
    $response['status'] = 1;
}
else
{
    $response['message'] = "Incomplete request";
    $response['status'] = 0;
    echo "Incomplete request";
}

echo json_encode($response);
?>
