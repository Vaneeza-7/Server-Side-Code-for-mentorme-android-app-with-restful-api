<?php
header('Content-Type: application/json');
include 'conn.php'; // Make sure this includes your database connection setup

$response = array();

// Check if all required data is provided
if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['city'], $_POST['country'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Check if the email exists and is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare the SQL statement to update user details
        $stmt = $conn->prepare("UPDATE `users` SET name = ?, phone = ?, city = ?, country = ? WHERE email = ?");
        $stmt->bind_param("sssss", $name, $phone, $city, $country, $email);

        if ($stmt->execute()) {
            // Check if any rows were actually updated
            if ($stmt->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'User details updated successfully';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'No user found with that email or no new data to update';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to update user details';
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email format';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Missing required parameters';
    http_response_code(400); // Bad request
}

$conn->close();

echo json_encode($response);
?>
