<?php
    include('../config/db.php');

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Extract product data from the form
        $sku = $_POST['sku'];
        $pname = $_POST['pname'];
        $category = $_POST['category'];
        $shortdesc = $_POST['shortdesc'];
        $longdesc = $_POST['longdesc'];
        $keywords = $_POST['keywords'];

        // Insert data into tblproduct_p
        $insertProductQuery = "INSERT INTO tblproduct_p (tblProduct_P_Name, tblProduct_P_SKU, tblProduct_P_Category, tblProduct_P_ShortDescription, tblProduct_P_LongDescription, tblProduct_P_MetaKeyWords, tblProduct_P_Status) 
                               VALUES ('$pname', '$sku', '$category', '$shortdesc', '$longdesc', '$keywords', 1)";
        $resultProduct = $conn->query($insertProductQuery);

        if ($resultProduct) {
            // Get the last inserted product ID
            $productId = $conn->insert_id;


            // Handle color associations
            if(!empty($_POST['selectedColors'])){
    		  $selectedColors = isset($_POST['selectedColors']) ? explode(",", $_POST['selectedColors']) : [];
    		}else{
    		  $selectedColors = [];
    		}

            foreach ($selectedColors as $colorId) {
                $insertColorQuery = "INSERT INTO tblcolor_r_product (tblColor_R_Product_ProductFK, tblColor_R_Product_ColorFK) 
                                     VALUES ('$productId', '$colorId')";
                $conn->query($insertColorQuery);
            }

            // Handle image URLs
            $targetDirectory = "./assets/products/";
            for ($i = 1; $i <= 4; $i++) {
                $imageFieldName = "image" . $i;
                if (!empty($_FILES[$imageFieldName]['name'])) {

                    // Generate a unique timestamp for each image
                    $timestamp = time();
                    
                    $uploadFileName = $timestamp . '_' . basename($_FILES[$imageFieldName]['name']);
                    $targetPath = $targetDirectory . $uploadFileName;

                    move_uploaded_file($_FILES[$imageFieldName]['tmp_name'], ".".$targetPath);

                    $imageUrl = $targetDirectory . $uploadFileName;

                    $insertImageQuery = "INSERT INTO tblimages_r_product (tblImages_R_Product_ProductFK, tblImages_R_Product_ImageURL) 
                                         VALUES ('$productId', '$imageUrl')";
                    $conn->query($insertImageQuery);
                }
            }

            // Handle related products
            for ($i = 1; $i <= 4; $i++) {
                $relatedProductFieldName = "relatedProduct" . $i;
                $relatedProductId = $_POST[$relatedProductFieldName];

                if (!empty($relatedProductId)) {
                    $insertRelatedProductQuery = "INSERT INTO tblrelated_r_product (tblRelated_R_Product_PProductFK, tblRelated_R_Product_RProductFK) 
                                                  VALUES ('$productId', '$relatedProductId')";
                    $conn->query($insertRelatedProductQuery);
                }
            }

            // Handle specifications
            for ($i = 1; $i <= 6; $i++) {
                $specIdFieldName = "spec_id_" . $i;
                $specValueFieldName = "spec_val_" . $i;

                $specId = $_POST[$specIdFieldName];
                $specValue = $_POST[$specValueFieldName];

                if (!empty($specId) && !empty($specValue)) {
                    $insertSpecQuery = "INSERT INTO tblspecification_r_product (tblSpecification_R_Product_ProductFK, tblSpecification_R_Product_SpecificationFK, tblSpecification_R_Product_SpecificationValue) 
                                        VALUES ('$productId', '$specId', '$specValue')";
                    $conn->query($insertSpecQuery);
                }
            }
            // Redirect or display success message
            header("Location: ../productsAED.php?added=1");
            exit();
        } else {
            // Handle database error
            $error = $conn->error;
            echo "Error: " . $error;
        }
    }

    // Close the database connection
    $conn->close();
?>
