<?php
session_start();
include('config/db.php');
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$x = [ '1' => 'Ho.Re.Ca', '2' => 'Medical', '3' => 'Salon & Spa' ];
$sql0 = "SELECT * FROM tblspecification_m";
$result0 = $conn->query($sql0);

if ($result0->num_rows > 0) {
    $spec_all = $result0->fetch_all(MYSQLI_ASSOC);
}else{
    $spec_all = [];
}

$sql0 = "SELECT * FROM tblcolor_m";
$result0 = $conn->query($sql0);

if ($result0->num_rows > 0) {
    $color_all = $result0->fetch_all(MYSQLI_ASSOC);
}else{
    $color_all = [];
}

$sql0 = "SELECT * FROM tblproduct_p";
$result0 = $conn->query($sql0);

if ($result0->num_rows > 0) {
    $product_all = $result0->fetch_all(MYSQLI_ASSOC);
}else{
    $product_all = [];
}

if($id!=0){
   $sql0 = "SELECT * FROM tblproduct_p WHERE tblProduct_P_PK = '$id'";
   $result0 = $conn->query($sql0);

   if ($result0->num_rows > 0) {
       $product = $result0->fetch_assoc();
   }else{
       $product = [];
   }

   $sql = "SELECT c.tblColor_ColorName,c.tblColor_PK
           FROM tblcolor_r_product crp
           INNER JOIN tblcolor_m c ON crp.tblColor_R_Product_ColorFK = c.tblColor_PK
           WHERE crp.tblColor_R_Product_ProductFK = $id";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       $color = $result->fetch_all(MYSQLI_ASSOC);
   }else{
       $color = [];
   }

   $sql = "SELECT s.tblSpecification_PK,s.tblSpecification_Name, srp.tblSpecification_R_Product_SpecificationValue
        FROM tblspecification_r_product srp
        INNER JOIN tblspecification_m s ON srp.tblSpecification_R_Product_SpecificationFK = s.tblSpecification_PK
        WHERE srp.tblSpecification_R_Product_ProductFK = $id";

   $result = $conn->query($sql);
   
   if ($result->num_rows > 0) {
       $specx = $result->fetch_all(MYSQLI_ASSOC);
   }else{
       $specx = [];
   }
   
   $sql = "SELECT tblImages_R_Product_ImageURL
        FROM tblimages_r_product
        WHERE tblImages_R_Product_ProductFK = $id";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       $imgx = $result->fetch_all(MYSQLI_ASSOC);
   }else{
       $imgx = [];
   }

   $sql_related_products = "
         SELECT p.tblProduct_P_PK, p.tblProduct_P_Name 
         FROM tblrelated_r_product trp
         INNER JOIN tblproduct_p p ON trp.tblRelated_R_Product_RProductFK  = p.tblProduct_P_PK
         WHERE trp.tblRelated_R_Product_PProductFK = $id 
         ";

   $result_related_products = $conn->query($sql_related_products);
   $rproducts = $result_related_products->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DYOR - View Products</title>
        <!-- Favicons -->
        <link href="img/favicon.png" rel="icon">
        <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
        <!-- Bootstrap core CSS -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!--external css-->
        <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
        <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet">
        <script src="lib/chart-master/Chart.js"></script>
        <style>
            tr:nth-child(even) {
                background-color: #f0f0f0;
            }
            tr:nth-child(odd) {
                background-color: #e8e8e8;
            }
            td:hover {
                background-color: #e0e0e0;
            }
            td{
                word-break: break-word;
            }
            th {
                background-color: #fff;
                color: #000;
            }
            tr {
                transition: background-color 0.3s ease;
            }

        </style>
    </head>
    <body>
        <section id="container">
            <?php include 'header.php';?>
            <h1 style="text-align:center;color: white;margin-top:130px">Product Details</h1>
            <div class="row content-panel" style="margin-left: 5%;width:90%;margin-top:20px">
                <div class="panel-body">
                    <h4>➤ Product Name : <?php echo $product['tblProduct_P_Name'];?></h4>
                    <br/>
                    <h4>➤ SKU : <?php echo $product['tblProduct_P_SKU'];?></h4>
                    <br/>

                    <h4>➤ Category : <?php echo $x[$product['tblProduct_P_Category']];?></h4>
                    <br/>

                    <h4>➤ Specification : </h4>

                        <ul style="margin-top: 15px ;">
                            <?php
                                foreach($specx as $sp ){
                                    $name = $sp["tblSpecification_Name"];
                                    $value = $sp["tblSpecification_R_Product_SpecificationValue"];
                                    echo "<li><h4>➤ $name : $value</h4></li>";
                                }

                            ?>
                        </ul>
                    <br/>

                    <h4>➤ Short Description : <?php echo $product['tblProduct_P_ShortDescription'];?></h4>
                    <br/>

                    <h4>➤ Description : <?php echo $product['tblProduct_P_LongDescription'];?></h4>
                    <br/>

                    <h4>➤ Keywords : <?php echo $product['tblProduct_P_MetaKeyWords'];?></h4>
                    <br/>

                    <h4>➤ Images :</h4>
                    <div style="display:flex;justify-content:center;gap:40px;margin-bottom:20px;flex-wrap:wrap">
                    <?php
                        foreach($imgx as $img){
                            $src=$img['tblImages_R_Product_ImageURL'];
                            echo "<img src='$src' width='200px' style='border:2px solid white;border-radius:10px;padding:10px'/>";
                        }

                    ?>

                    <br/>
                </div>
            </div>

        </section>
        <br/>
        <br/>
    </body>
</html>