<?php
// Include your database connection file here
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cId = $_POST['colorid'];

    $sql = "DELETE FROM tblcolor_m WHERE tblColor_PK = '$cId'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../colorAED.php?colordeleted=1");
    } else {
        // Failed to delete
        header("Location: ../colorAED.php?colordeleted=0");
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
