<?php
   include('admin/config/db.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $search = $_POST['search'];
   $condition = empty($search) ? '' : "WHERE tblProduct_P_Name LIKE '%$search%'";

	// Fetch products with associated data
	$query = "SELECT * FROM tblproduct_p $condition AND tblProduct_P_Status = 1";
	$result = $conn->query($query);

	$products = array();

	while ($row = $result->fetch_assoc()) {
	    $product = array(
	        'product' => $row,
	        'images' => array(),
	        'colors' => array(),
	        'specifications' => array(),
	        'related_products' => array()
	    );

	    // Fetch associated images
	    $imageQuery = "SELECT * FROM tblimages_r_product WHERE tblImages_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $imageResult = $conn->query($imageQuery);
	    while ($imageRow = $imageResult->fetch_assoc()) {
	        $product['images'][] = $imageRow;
	    }

	    // Fetch associated colors
	    $colorQuery = "SELECT c.* FROM tblcolor_m c
	                   INNER JOIN tblcolor_r_product cr ON c.tblColor_PK = cr.tblColor_R_Product_ColorFK
	                   WHERE cr.tblColor_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $colorResult = $conn->query($colorQuery);
	    while ($colorRow = $colorResult->fetch_assoc()) {
	        $product['colors'][] = $colorRow;
	    }

	    // Fetch associated specifications
	    $specQuery = "SELECT s.*, sr.tblSpecification_R_Product_SpecificationValue
	                  FROM tblspecification_m s
	                  INNER JOIN tblspecification_r_product sr ON s.tblSpecification_PK = sr.tblSpecification_R_Product_SpecificationFK
	                  WHERE sr.tblSpecification_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $specResult = $conn->query($specQuery);
	    while ($specRow = $specResult->fetch_assoc()) {
	        $product['specifications'][] = $specRow;
	    }

	    // Fetch related products
	    $relatedQuery = "SELECT rp.* FROM tblrelated_r_product trp
	                     INNER JOIN tblproduct_p rp ON trp.tblRelated_R_Product_RProductFK = rp.tblProduct_P_PK
	                     WHERE trp.tblRelated_R_Product_PProductFK = " . $row['tblProduct_P_PK'];
	    $relatedResult = $conn->query($relatedQuery);
	    while ($relatedRow = $relatedResult->fetch_assoc()) {
	        $product['related_products'][] = $relatedRow;
	    }

	    $products[] = $product;
	}
}
elseif(isset($_GET['query'])){
    $search = isset($_GET['query']) ? $_GET['query'] : '';
    $condition = empty($search) ? '' : "WHERE tblProduct_P_Name LIKE '%$search%'";
    

    // Decode the query string
    $queryDecoded = urldecode($search);
    
    $values = explode(',', $queryDecoded);
    
    $sanitizedValues = array_map(function($value) use ($conn) {
        return "'%" . mysqli_real_escape_string($conn, trim($value)) . "%'";
    }, $values);


	// Fetch products with associated data
	$query = "SELECT *
                FROM tblproduct_p
                INNER JOIN tblspecification_r_product tsrp ON tsrp.tblSpecification_R_Product_ProductFK = tblproduct_p.tblProduct_P_PK
                WHERE tsrp.tblSpecification_R_Product_SpecificationFK = 15 
                AND (";
    
    for($i=0;$i<count($sanitizedValues);$i++){
        $val = $sanitizedValues[$i];
        if($i==count($sanitizedValues)-1){
            $query .=" OR tsrp.tblSpecification_R_Product_SpecificationValue LIKE $val )";
        }
        elseif($i==0){
            $query .=" tsrp.tblSpecification_R_Product_SpecificationValue LIKE $val ";
        }
        else{
            $query .=" OR tsrp.tblSpecification_R_Product_SpecificationValue LIKE $val";
        }
    }
    $query .= " AND tblproduct_p.tblProduct_P_Status = 1;";

	$result = $conn->query($query);
	$products = array();

	while ($row = $result->fetch_assoc()) {
	    $product = array(
	        'product' => $row,
	        'images' => array(),
	        'colors' => array(),
	        'specifications' => array(),
	        'related_products' => array()
	    );

	    // Fetch associated images
	    $imageQuery = "SELECT * FROM tblimages_r_product WHERE tblImages_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $imageResult = $conn->query($imageQuery);
	    while ($imageRow = $imageResult->fetch_assoc()) {
	        $product['images'][] = $imageRow;
	    }

	    // Fetch associated colors
	    $colorQuery = "SELECT c.* FROM tblcolor_m c
	                   INNER JOIN tblcolor_r_product cr ON c.tblColor_PK = cr.tblColor_R_Product_ColorFK
	                   WHERE cr.tblColor_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $colorResult = $conn->query($colorQuery);
	    while ($colorRow = $colorResult->fetch_assoc()) {
	        $product['colors'][] = $colorRow;
	    }

	    // Fetch associated specifications
	    $specQuery = "SELECT s.*, sr.tblSpecification_R_Product_SpecificationValue
	                  FROM tblspecification_m s
	                  INNER JOIN tblspecification_r_product sr ON s.tblSpecification_PK = sr.tblSpecification_R_Product_SpecificationFK
	                  WHERE sr.tblSpecification_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $specResult = $conn->query($specQuery);
	    while ($specRow = $specResult->fetch_assoc()) {
	        $product['specifications'][] = $specRow;
	    }

	    // Fetch related products
	    $relatedQuery = "SELECT rp.* FROM tblrelated_r_product trp
	                     INNER JOIN tblproduct_p rp ON trp.tblRelated_R_Product_RProductFK = rp.tblProduct_P_PK
	                     WHERE trp.tblRelated_R_Product_PProductFK = " . $row['tblProduct_P_PK'];
	    $relatedResult = $conn->query($relatedQuery);
	    while ($relatedRow = $relatedResult->fetch_assoc()) {
	        $product['related_products'][] = $relatedRow;
	    }

	    $products[] = $product;
	}
    
}
else{
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $condition = empty($search) ? '' : "WHERE tblProduct_P_Name LIKE '%$search%'";

	// Fetch products with associated data
	$query = "SELECT * FROM tblproduct_p $condition AND tblProduct_P_Status = 1";
	$result = $conn->query($query);

	$products = array();

	while ($row = $result->fetch_assoc()) {
	    $product = array(
	        'product' => $row,
	        'images' => array(),
	        'colors' => array(),
	        'specifications' => array(),
	        'related_products' => array()
	    );

	    // Fetch associated images
	    $imageQuery = "SELECT * FROM tblimages_r_product WHERE tblImages_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $imageResult = $conn->query($imageQuery);
	    while ($imageRow = $imageResult->fetch_assoc()) {
	        $product['images'][] = $imageRow;
	    }

	    // Fetch associated colors
	    $colorQuery = "SELECT c.* FROM tblcolor_m c
	                   INNER JOIN tblcolor_r_product cr ON c.tblColor_PK = cr.tblColor_R_Product_ColorFK
	                   WHERE cr.tblColor_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $colorResult = $conn->query($colorQuery);
	    while ($colorRow = $colorResult->fetch_assoc()) {
	        $product['colors'][] = $colorRow;
	    }

	    // Fetch associated specifications
	    $specQuery = "SELECT s.*, sr.tblSpecification_R_Product_SpecificationValue
	                  FROM tblspecification_m s
	                  INNER JOIN tblspecification_r_product sr ON s.tblSpecification_PK = sr.tblSpecification_R_Product_SpecificationFK
	                  WHERE sr.tblSpecification_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
	    $specResult = $conn->query($specQuery);
	    while ($specRow = $specResult->fetch_assoc()) {
	        $product['specifications'][] = $specRow;
	    }

	    // Fetch related products
	    $relatedQuery = "SELECT rp.* FROM tblrelated_r_product trp
	                     INNER JOIN tblproduct_p rp ON trp.tblRelated_R_Product_RProductFK = rp.tblProduct_P_PK
	                     WHERE trp.tblRelated_R_Product_PProductFK = " . $row['tblProduct_P_PK'];
	    $relatedResult = $conn->query($relatedQuery);
	    while ($relatedRow = $relatedResult->fetch_assoc()) {
	        $product['related_products'][] = $relatedRow;
	    }

	    $products[] = $product;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>DYOR - Search</title>
      <meta name="keywords" content="HTML5 Template" />
      <meta name="description" content="DYOR Industries">
      <meta name="author" content="Vhiron by Jinshaashan Info">
      <meta name="url" content="https://vhiron.com/">
      <meta name='copyright' content='DYOR Industries'>
      <meta name='Classification' content='Business'>
      <meta name='robots' content='index,follow'>
      <meta name='coverage' content='Worldwide'>
      <meta name='distribution' content='Global'>
      <meta name='rating' content='General'>
      <meta name='revisit-after' content='7 days'>
      <meta name='target' content='all'>
      <link rel="icon" type="image/png" href="images/icons/favicon.png">
      <script>
         WebFontConfig = {
            google: { families: ['Poppins:400,500,600,700'] }
         };
         (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = 'js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
         })(document);
      </script>
      <link rel="stylesheet" type="text/css" href="vendor/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/animate/animate.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/magnific-popup/magnific-popup.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/owl-carousel/owl.carousel.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/nouislider/nouislider.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/sticky-icon/stickyicon.css">
      <link rel="stylesheet" type="text/css" href="css/style.min.css">
      <link rel="stylesheet" type="text/css" href="css/demo7.min.css">
      <style>
            .available-colors {
                
                margin-top: 10px;
            }
            
            .colors-label {
                font-weight: bold;
            }
            
            .color-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .color-list li {
                display: inline-block;
                margin-right: 10px;
            }
            
            .color-list li a {
                display: block;
                width: 15px;
                height: 15px;
                border: 1px solid grey;
                border-radius: 5px;
            }
            
            .color-list li a:hover {
                border-color: #333; /* Change border color on hover */
            }
      </style>
   </head>
   <body>
      <div class="page-wrapper">
         <?php include 'header.php';?>
         <main class="main">
            <div class="page-header" style="background-image: url('images/page-header/about-us.jpg'); background-color: #3C63A4;">
               <h3 class="page-subtitle">Categories</h3>
               <h1 class="page-title">Search Results</h1>
               <ul class="breadcrumb">
                  <li><a href="index.php"><i class="d-icon-home"></i></a></li>
                  <li class="delimiter">/</li>
                  <li><a href="categories.php"><i class="d-icon-search"></i></a></li>
               </ul>
            </div>
            <br/>
            <div class="page-content mb-10 pb-6">
               <div class="container">
                  <div class="row main-content-wrap gutter-lg">
                     <div class="main-content">
                        <div class="row cols-2 cols-sm-3 cols-md-4 product-wrapper">
                           <?php foreach ($products as $p) :?>
                           <div class="product-wrap" style="height: 400px; overflow: hidden;"> <!-- Adjust the height as needed -->
                                <div class="product" style="height: 100%; display: flex; flex-direction: column;">
                                    <figure class="product-media" style="border: 1px solid #d3986a; border-radius:10px; flex: 1 0 0; overflow: hidden;">
                                        <img src="<?php echo './admin'.ltrim($p['images'][0]['tblImages_R_Product_ImageURL'],'.');?>" alt="product" style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;">
                                        <div class="product-label-group">
                                            <label class="product-label label-new">new</label>
                                        </div>
                                        <div class="product-action">
                                            <a href="./productdetails.php?id=<?= $p['product']['tblProduct_P_PK']?>" class="btn-product btn-quickview" title="Quick View">View</a>
                                        </div>
                                    </figure>
                                    <div class="product-details" style="flex-shrink: 0;"> <!-- Ensure the details section does not grow -->
                                        <div class="product-cat">
		                                    <?php if($p['product']['tblProduct_P_Category'] == '1'):?>
		                                        <a href="horeca.php">Ho.Re.Ca</a>
		                                    <?php elseif($p['product']['tblProduct_P_Category'] == '2'):?>
		                                        <a href="medical.php">Medical</a>
		                                    <?php elseif($p['product']['tblProduct_P_Category'] == '3'):?>
		                                        <a href="salonspa.php">Salon & SPA</a>
		                                    <?php endif;?>
		                                 </div>
                                        <h3 class="product-name" style="font-weight:600;font-size: 16px;">
                                            <a href="./productdetails.php?id=<?= $p['product']['tblProduct_P_PK']?>"><?php echo $p["product"]["tblProduct_P_Name"];?></a>
                                        </h3>
                                        <!--<div class="product-price">-->
                                        <!--   <ins class="new-price">₹ 199.00</ins><del class="old-price">$210.00</del>-->
                                        <!--</div>-->
                                        <div class="available-colors">
                                            <ul class="color-list">
                                                <?php foreach($p['colors'] as $c):?>
                                                <li><a href="#" style="background-color: <?php echo $c['tblColor_ColorName'];?>"></a></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <?php endforeach; ?>
                        </div>
                     </div>
                     <aside class="col-lg-3 sidebar shop-sidebar">
                        <div class="sidebar-overlay"></div>
                        <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
                        <div class="sidebar-content">
                           <div class="filter-actions mb-4">
                              <a href="#" class="sidebar-toggle-btn toggle-remain btn btn-sm btn-outline 
                                 btn-primary btn-rounded btn-icon-right">Filter<i class="d-icon-arrow-left"></i></a>
                              <a href="#" class="filter-clean text-primary">Clean All</a>
                           </div>
                           <div class="widget widget-collapsible">
                              <h3 class="widget-title">Product Categories</h3>
                              <ul class="widget-body filter-items search-ul">
                                 <li>
                                    <a href="#">Clothing<span class="count">(6)</span></a>
                                    <ul>
                                       <li><a href="#">Summer sale<span class="count">(2)</span></a></li>
                                       <li><a href="#">Shirts<span class="count">(3)</span></a></li>
                                       <li><a href="#">Trunks<span class="count">(1)</span></a></li>
                                    </ul>
                                 </li>
                                 <li><a href="#">Shoes<span class="count">(5)</span></a></li>
                                 <li><a href="#">Men<span class="count">(8)</span></a></li>
                                 <li><a href="#">Women<span class="count">(3)</span></a></li>
                                 <li><a href="#">Bags & Backpacks<span class="count">(5)</span></a></li>
                                 <li>
                                    <a href="#">Watches<span class="count">(4)</span></a>
                                    <ul>
                                       <li><a href="#">Men's<span class="count">(2)</span></a></li>
                                       <li><a href="#">Woment's<span class="count">(2)</span></a></li>
                                    </ul>
                                 </li>
                                 <li>
                                    <a href="#">Accessosries<span class="count">(1)</span></a>
                                    <ul>
                                       <li><a href="#">Ring<span class="count">(1)</span></a></li>
                                    </ul>
                                 </li>
                              </ul>
                           </div>
                           <div class="widget widget-collapsible">
                              <h3 class="widget-title">Filter by Price</h3>
                              <div class="widget-body">
                                 <form action="#">
                                    <div class="filter-price-slider"></div>
                                    <div class="filter-actions">
                                       <div class="filter-price-text mb-4">Price:
                                          <span class="filter-price-range"></span>
                                       </div>
                                       <button type="submit" class="btn btn-sm btn-dark btn-filter btn-rounded">Filter</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="widget widget-collapsible">
                              <h3 class="widget-title">Size</h3>
                              <ul class="widget-body filter-items">
                                 <li><a href="#">Extra Large<span class="count">(2)</span></a></li>
                                 <li><a href="#">Large<span class="count">(5)</span></a></li>
                                 <li><a href="#">Medium<span class="count">(8)</span></a></li>
                                 <li><a href="#">Small<span class="count">(1)</span></a></li>
                              </ul>
                           </div>
                           <div class="widget widget-collapsible">
                              <h3 class="widget-title">Color</h3>
                              <ul class="widget-body filter-items">
                                 <li><a href="#">Black<span class="count">(2)</span></a></li>
                                 <li><a href="#">Blue<span class="count">(5)</span></a></li>
                                 <li><a href="#">Green<span class="count">(8)</span></a></li>
                                 <li><a href="#">White<span class="count">(1)</span></a></li>
                              </ul>
                           </div>
                           <div class="widget widget-collapsible">
                              <h3 class="widget-title">Brands</h3>
                              <ul class="widget-body filter-items">
                                 <li><a href="#">SLS<span>(2)</span></a></li>
                                 <li><a href="#">Cinderella<span>(5)</span></a></li>
                                 <li><a href="#">Comedy<span>(8)</span></a></li>
                                 <li><a href="#">Rightcheck<span>(1)</span></a></li>
                              </ul>
                           </div>
                        </div>
                     </aside>
                  </div>
               </div>
            </div>
         </main>
       <?php include 'footer.php';?>
      </div>
     <?php include 'mobilemenu.php';?>
      <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/sticky/sticky.min.js"></script>
      <script src="vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
      <script src="vendor/elevatezoom/jquery.elevatezoom.min.js"></script>
      <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <script src="vendor/owl-carousel/owl.carousel.min.js"></script>
      <script src="vendor/nouislider/nouislider.min.js"></script>
      <script src="js/main.min.js"></script>
   </body>
</html>
