<?php
	include('../config/db.php');

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		$deleteProductQuery = "DELETE FROM tblproduct_p WHERE tblProduct_P_PK = $id";
    
	    if ($conn->query($deleteProductQuery) === TRUE) {
	        // Deletion successful
	        // Redirect to the page you want after deletion
	        header("Location: ../productsAED.php?deleted=1");
	        exit();
	    } else {
	        // Deletion failed, handle the error (redirect or show an error message)
	        echo "Error deleting record: " . $conn->error;
	    }

	}
?>