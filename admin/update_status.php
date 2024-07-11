<?php
include("./config/db.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get JSON data from the AJAX request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data && isset($data['id']) && isset($data['status'])) {
    // Prepare SQL statement to update database
    $id = $data['id'];
    $status = $data['status'];
    $sql = "UPDATE tblproduct_p SET tblProduct_P_Status = '$status' WHERE tblProduct_P_PK = '$id'";
    
    // Execute the SQL statement
    if ($conn->query($sql)) {
        // Output success message
        echo json_encode(array('success' => true, 'message' => 'Status updated successfully.'));
    } else {
        // Output error message
        echo json_encode(array('success' => false, 'message' => 'Error updating status: ' . mysqli_error($conn)));
    }
} else {
    // Output error message if required data is missing
    echo json_encode(array('success' => false, 'message' => 'Missing ID or status.'));
}

// Close connection
$conn->close();
?>
