<?php
// Include your database connection file here
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cId = $_POST['specid'];

    $sql = "DELETE FROM tblspecification_m WHERE tblSpecification_PK = '$cId'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../specificationsAED.php?specdeleted=1");
    } else {
        // Failed to delete
        header("Location: ../specificationsAED.php?specdeleted=0");
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
