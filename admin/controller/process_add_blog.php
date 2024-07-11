<?php
	include('../config/db.php');

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$title = $_POST["title"];
		$p1 = $_POST["p1"];
		$p2 = $_POST["p2"];
		$title2 = $_POST["title2"];
		$secondpara = $_POST["secondpara"];
		$quote = $_POST["quote"];
		$keywords = $_POST['keywords'];

		echo var_dump($_POST);
		if(!empty($title)){
			$targetDirectory = "./admin/assets/blog/";
			$imageFieldName = 'image1';
			if (!empty($_FILES[$imageFieldName]['name'])) {

                // Generate a unique timestamp for each image
                $timestamp = time();
                
                $uploadFileName = $timestamp . '_' . basename($_FILES[$imageFieldName]['name']);
                $targetPath = $targetDirectory . $uploadFileName;

                move_uploaded_file($_FILES[$imageFieldName]['tmp_name'], ".".$targetPath);

                $imageUrl = $targetDirectory . $uploadFileName;
            }

            $imageFieldName = 'image2';
			if (!empty($_FILES[$imageFieldName]['name'])) {

                // Generate a unique timestamp for each image
                $timestamp = time();
                
                $uploadFileName = $timestamp . '_' . basename($_FILES[$imageFieldName]['name']);
                $targetPath = $targetDirectory . $uploadFileName;

                move_uploaded_file($_FILES[$imageFieldName]['tmp_name'], ".".$targetPath);

                $imageUrl2 = $targetDirectory . $uploadFileName;
            }


			$sql = "INSERT INTO tblblog (title,description_one,description_two, header_two, paragraph_two, quote, imagepath_one, imagepath_two,tags) 
			VALUES (
					'$title',
					'$p1',
					'$p2',
					'$title2',
					'$secondpara',
					'$quote',
					'$imageUrl',
					'$imageUrl2',
					'$keywords'
					)";
			// Execute the statement
		    $result = $conn->query($sql);
		    // Check if the query was successful
		    if ($result) {
		        // Redirect to a success page or back to the form with a success message
		        header("Location: ../blog.php?added=1");
		        exit;
		    } else {
		        // Handle errors, redirect back to the form with an error message, etc.
		        echo "Error: " . $conn->error;
		        header("Location: ../blog.php?added=0");
		        exit;
		    }
		}
		else {
			echo "ERROR !!!";
		}
	}else{
		echo "INVALID REQUEST";
	}

?>