<?php

include "./admin/config/db.php";

$post_data = file_get_contents("php://input");

// Decode the JSON data
$json_data = json_decode($post_data, true);

// Check if JSON decoding was successful
if ($json_data === null) {
    // JSON decoding failed
    $response = array('success' => false, 'message' => 'Failed to decode JSON data');
    echo json_encode($response);
    exit; // Stop further execution
}

// Now $json_data contains the decoded JSON data
// You can access the data like an associative array
$email = isset($json_data['email']) ? $json_data['email'] : '';

// Validate the email address (you can add more validation here if needed)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = array('success' => false, 'message' => 'Invalid email address');
    echo json_encode($response);
    exit; // Stop further execution
}

// Check if the email already exists in the database
$sql = "SELECT email FROM tblemail WHERE email = '$email'";
$result = $conn->query($sql);

// If the email already exists, return an error
if ($result->num_rows > 0) {
    $response = array('success' => false, 'message' => 'Email already exists');
    echo json_encode($response);
    exit; // Stop further execution
}

// Prepare SQL statement to insert the email
$sql = "INSERT INTO tblemail (email) VALUES ('$email')";

// Execute SQL statement to insert the email
if ($conn->query($sql) === TRUE) {
    $response = array('success' => true);
    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Failed to subscribe, please try again later');
    echo json_encode($response);
}

// Close connections
$conn->close();

?>

