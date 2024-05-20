<?php
header('Content-Type: application/json');
include 'conn.php';
$response = array();

if (isset($_POST['image'], $_POST['localhost'])) {
    $image = $_POST['image'];
    $localhost = $_POST['localhost'];
    $name = "image_" . time() . ".jpeg"; 
    $path = "messageMedia/$name";
    
    if (!file_exists('messageMedia')) {
        mkdir('messageMedia', 0777, true); 
    }

    // Decode the image from base64 and save
    if (file_put_contents($path, base64_decode($image))) {
        $fullPath = $localhost . "mentorme/$path"; 
        
        $response['url'] = $fullPath;
        $response['message'] = "Image uploaded and saved successfully";
        $response['status'] = 1;
    } else {
        $response['message'] = "Failed to save image file";
        $response['status'] = 0;
    }
} else {
    $response['message'] = "Incomplete request, image and localhost parameters required";
    $response['status'] = 0;
}

echo json_encode($response);
?>
