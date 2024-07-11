<?php
include("../config/db.php");

$oldFile = $_POST['filename'];
unlink($oldFile);
$sql = "DELETE FROM tblimages_r_product WHERE tblImages_R_Product_ImageURL = '$oldFile';";
if ($conn->query($sql)) {
    // Output success message
    echo json_encode(array('success' => true, 'message' => 'Image Removed Successfully.'));
} else {
    // Output error message
    echo json_encode(array('success' => false, 'message' => 'Error updating ' . mysqli_error($conn)));
}
$conn->close();

?>