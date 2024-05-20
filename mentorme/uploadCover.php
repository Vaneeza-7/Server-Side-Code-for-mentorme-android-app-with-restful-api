<?php
header('Content-Type: application/json');
include 'conn.php'; 
$response = array();

if(isset($_POST['image'], $_POST['email'], $_POST['localhost']))
{
    $image = $_POST['image'];
    $email = $_POST['email'];
    $localhost = $_POST['localhost']; //in format http://192.168.56.9/
    $name = "image_" . $email . ".jpeg"; 
    $path = "coverImages/$name";
    
    if (file_put_contents($path, base64_decode($image))) {
        $fullPath = $localhost . "mentorme/$path"; 
        
        $stmt = $conn->prepare("UPDATE `users` SET cp = ? WHERE email = ?");
        $stmt->bind_param("ss", $fullPath, $email);
        
        if ($stmt->execute()) {
            $response['url'] = $fullPath;
            $response['message'] = "Image uploaded and saved successfully";
            $response['status'] = 1;
        } else {
            $response['message'] = "Failed to update user profile with image";
            $response['status'] = 0;
        }
        $stmt->close();
    } else {
        $response['message'] = "Failed to save image file";
        $response['status'] = 0;
    }
}
else
{
    $response['message'] = "Incomplete request or invalid email";
    $response['status'] = 0;
}

$conn->close();
echo json_encode($response);
?>
