<?php
	include('../config/db.php');
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		// Product Data
		$id        = $_POST['id'];
		$sku       = $_POST['sku'];
        $pname     = $_POST['pname'];
        $category  = $_POST['category'];
        $shortdesc = $_POST['shortdesc'];
        $longdesc  = $_POST['longdesc'];
        $keywords  = $_POST['keywords'];



		// Product Update Query
		$usql = "
				UPDATE tblproduct_p 
				SET tblProduct_P_Name = '$pname',
					tblProduct_P_SKU =  '$sku',
					tblProduct_P_Category = '$category',
					tblProduct_P_ShortDescription = '$shortdesc',
					tblProduct_P_LongDescription = '$longdesc',
					tblProduct_P_MetaKeyWords = '$keywords'
				WHERE 
					tblProduct_P_PK = '$id'
				";

		$result = $conn->query($usql);
		
		if($result) {
			
			$deleteColorsQuery = "DELETE FROM tblcolor_r_product WHERE tblColor_R_Product_ProductFK = $id";
    		$conn->query($deleteColorsQuery);
			
    		// Handle color associations
    		if(!empty($_POST['selectedColors'])){
    		  $selectedColors = isset($_POST['selectedColors']) ? explode(",", $_POST['selectedColors']) : [];
    		}else{
    		  $selectedColors = [];
    		}

            foreach ($selectedColors as $colorId) {
                $insertColorQuery = "INSERT INTO tblcolor_r_product (tblColor_R_Product_ProductFK, tblColor_R_Product_ColorFK) 
                                     VALUES ('$id', '$colorId')";
                $conn->query($insertColorQuery);
            }

            $targetDirectory = "./assets/products/";
            for ($i = 1; $i <= 4 ; $i++) {

            	

            	if(!empty($_FILES["image$i"]["name"])){
            		$oldURL = $_POST["e_image$i"];
            		if(!empty($oldURL)){
		    			unlink($oldURL);

		    			$timestamp = time();
	                    $uploadFileName = $timestamp . '_' . basename($_FILES["image$i"]['name']);
	                    $targetPath = $targetDirectory . $uploadFileName;

	                    move_uploaded_file($_FILES["image$i"]['tmp_name'], ".".$targetPath);

	                    $imageUrl = $targetDirectory . $uploadFileName;
		    			
		    			$updateImageQuery = "UPDATE tblimages_r_product SET tblImages_R_Product_ImageURL = '$imageUrl' WHERE 
		    			tblImages_R_Product_ImageURL = '$oldURL'";
            			
            			$conn->query($updateImageQuery);
            		
            		}
            		else{
            			$timestamp = time();
	                    $uploadFileName = $timestamp . '_' . basename($_FILES["image$i"]['name']);
	                    $targetPath = $targetDirectory . $uploadFileName;
	                    
	                    move_uploaded_file($_FILES["image$i"]['tmp_name'], ".".$targetPath);

	                    $imageUrl = $targetDirectory . $uploadFileName;
	                    $insertImageQuery = "INSERT INTO tblimages_r_product (tblImages_R_Product_ProductFK, tblImages_R_Product_ImageURL) 
	                                         VALUES ('$id', '$imageUrl')";
	                    $conn->query($insertImageQuery);
            		}
            	}
            }

            $deleteColorsQuery = "DELETE FROM tblrelated_r_product WHERE tblRelated_R_Product_PProductFK = '$id'";
    		$conn->query($deleteColorsQuery);

            // Handle related products
            for ($i = 1; $i <= 4; $i++) {
                $relatedProductFieldName = "relatedProduct" . $i;
                $relatedProductId = $_POST[$relatedProductFieldName];
                
                if (!empty($relatedProductId)) {
                    $insertRelatedProductQuery = "INSERT INTO tblrelated_r_product (tblRelated_R_Product_PProductFK, tblRelated_R_Product_RProductFK)
                                                  VALUES ('$id', '$relatedProductId')";
                    $conn->query($insertRelatedProductQuery);
                }
            }

            $deleteColorsQuery = "DELETE FROM tblspecification_r_product WHERE tblSpecification_R_Product_ProductFK = $id";
    		$conn->query($deleteColorsQuery);

            // Handle specifications
            for ($i = 1; $i <= 6; $i++) {
                $specIdFieldName = "spec_id_" . $i;
                $specValueFieldName = "spec_val_" . $i;

                $specId = $_POST[$specIdFieldName];
                $specValue = $_POST[$specValueFieldName];

                if (!empty($specId) && !empty($specValue)) {
                    $insertSpecQuery = "INSERT INTO tblspecification_r_product (tblSpecification_R_Product_ProductFK, tblSpecification_R_Product_SpecificationFK, tblSpecification_R_Product_SpecificationValue) 
                                        VALUES ('$id', '$specId', '$specValue')";
                    $conn->query($insertSpecQuery);
                }
            }

            header("Location: ../productsAED.php?edited=1");
		}
		else{
			exit();
		}


	}
	// Close the database connection
    $conn->close();
?>