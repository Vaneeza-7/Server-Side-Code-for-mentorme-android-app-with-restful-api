<?php
header('Content-Type: application/json');
include 'conn.php'; 
$response = array();

if(isset($_POST['video'], $_POST['email'], $_POST['localhost']))
{
    $image = $_POST['video'];
    $email = $_POST['email'];
    $localhost = $_POST['localhost']; //in format http://192.168.56.9/
    $name = "video_" . $email . ".mp4"; 
    $path = "mentorVideos/$name";
    
    if (file_put_contents($path, base64_decode($image))) {
        $fullPath = $localhost . "mentorme/$path"; 
        
        $stmt = $conn->prepare("UPDATE `mentors` SET video = ? WHERE email = ?");
        $stmt->bind_param("ss", $fullPath, $email);
        
        if ($stmt->execute()) {
            $response['url'] = $fullPath;
            $response['message'] = "Video uploaded and saved successfully";
            $response['status'] = 1;
        } else {
            $response['message'] = "Failed to update mentor profile with video";
            $response['status'] = 0;
        }
        $stmt->close();
    } else {
        $response['message'] = "Failed to save video file";
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
