<?php
	include('../config/db.php');

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$name = $_POST["color_name"];
		$SpecName = strtoupper($name);
		$SpecName = $conn->real_escape_string($SpecName);
		echo $name;
		if(!empty($name)){
			$sql = "INSERT INTO tblcolor_m (tblColor_ColorName) VALUES ('$SpecName')";
			// Execute the statement
		    $result = $conn->query($sql);
		    // Check if the query was successful
		    if ($result) {
		        // Redirect to a success page or back to the form with a success message
		        header("Location: ../colorAED.php?coloradded=1");
		        exit;
		    } else {
		        // Handle errors, redirect back to the form with an error message, etc.
		        echo "Error: " . $conn->error;
		        header("Location: ../colorAED.php?coloradded=0");
		        exit;
		    }
		}
		else {
			echo "Specification Name is Empty !!!";
		}
	}else{
		echo "INVALID REQUEST";
	}

?>