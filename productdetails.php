<?php
   include('admin/config/db.php');
   $category = 1;
   $id = isset($_GET['id']) ? $_GET['id'] : 0;
// Fetch products with associated data
   $query = "SELECT * FROM tblproduct_p WHERE tblProduct_P_PK=$id AND tblProduct_P_Status = 1";
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
     $ix = $row['tblProduct_P_PK'];
    // Fetch related products
    $relatedQuery = "SELECT rp.*, MIN(ip.tblImages_R_Product_PK) AS image_id,ip.*
                    FROM tblrelated_r_product trp
                    INNER JOIN tblproduct_p rp ON trp.tblRelated_R_Product_RProductFK = rp.tblProduct_P_PK
                    LEFT JOIN tblimages_r_product ip ON ip.tblImages_R_Product_ProductFK = rp.tblProduct_P_PK
                    WHERE trp.tblRelated_R_Product_PProductFK = $ix
                    GROUP BY rp.tblProduct_P_PK;";

    $relatedResult = $conn->query($relatedQuery);
    while ($relatedRow = $relatedResult->fetch_assoc()) {
        $product['related_products'][] = $relatedRow;
    }
    
    $products[] = $product;
}
// echo var_dump($products);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>DYOR: <?php echo $products[0]["product"]["tblProduct_P_Name"];?></title>
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
      <style>
        .zoomContainer{
            display:none;
        }
      </style>
      <link rel="stylesheet" type="text/css" href="vendor/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/animate/animate.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/magnific-popup/magnific-popup.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/owl-carousel/owl.carousel.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/photoswipe/photoswipe.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/photoswipe/default-skin/default-skin.min.css">
      <link rel="stylesheet" type="text/css" href="vendor/sticky-icon/stickyicon.css">
      <link rel="stylesheet" type="text/css" href="css/style.min.css">
	  <link rel="stylesheet" type="text/css" href="css/demo7.min.css">
   </head>
   <body>
      <div class="page-wrapper">
         <?php include 'header.php';?>
         <main class="main mt-6 single-product">
            <div class="page-content mb-10 pb-6">
               <div class="container">
                  <div class="product product-single row mb-7">
                     <div class="col-md-6 sticky-sidebar-wrapper">
                        <div class="product-gallery pg-vertical sticky-sidebar" data-sticky-options="{'minWidth': 767}">
                           <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
                               <?php foreach ($products[0]["images"] as  $p):?>
                              <figure class="product-image">
                                 <img src="<?php echo './admin'.ltrim($p['tblImages_R_Product_ImageURL'],'.');?>" data-zoom-image="<?php echo './admin'.ltrim($p['tblImages_R_Product_ImageURL'],'.');?>" alt="Product" width="800" height="900">
                              </figure>
                              <?php endforeach;?>
                           </div>
                           <div class="product-thumbs-wrap">
                              <div class="product-thumbs">
                                  <?php foreach ($products[0]["images"] as  $p):?>
                                    <div class="product-thumb active">
                                      <img src="<?php echo './admin'.ltrim($p['tblImages_R_Product_ImageURL'],'.');?>"  alt="Product" width="109" height="122">
                                    </div>
                                 <?php endforeach;?>
                              </div>
                              <button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
                              <button class="thumb-down disabled"><i class="fas fa-chevron-right"></i></button>
                           </div>
                           <div class="product-label-group">
                              <label class="product-label label-new">new</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="product-details">
                           <div class="product-navigation">
                              <ul class="breadcrumb breadcrumb-lg">
                                 <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                                 <li><a href="#" class="active">Products</a></li>
                                 <li>Detail</li>
                              </ul>
                           </div>
                           <h2 class="product-name"><?php echo $products[0]["product"]["tblProduct_P_Name"];?></h2>
                           <div class="product-meta">
                              SKU: <span class="product-sku"><?php echo $products[0]["product"]["tblProduct_P_SKU"];?></span>
                              BRAND: <span class="product-brand">DYOR</span>
                           </div>
                           <div class="product-price">Colors</div>
                           <div class="product-variations">
                              <?php foreach ( $products[0]["colors"] as $p ):?>
                                <a class="color" href="" style="height:15px; width:15px;border: 1px solid grey; border-radius:5px; background-color: <?php echo $p['tblColor_ColorName'];?>"></a>
							  <?php endforeach;?>
                           </div>
                           
                           <br/>
                           <hr class="product-divider mb-3">
                           <p class="product-short-desc">
                               <?php echo $products[0]["product"]["tblProduct_P_ShortDescription"];?>
                           </p>
                           <div id="product-tab-description">
                              <table class="table">
                                    <tbody>
                                       <?php foreach($products[0]["specifications"] as $p):?>
                                           <tr>
                                              <th class="font-weight-semi-bold text-dark pl-0"><?php echo $p["tblSpecification_Name"];?></th>
                                              <td class="pl-4"><?php echo $p["tblSpecification_R_Product_SpecificationValue"];?></td>
                                           </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                 </table>
                           </div>
                           <div class="product-footer">
                              <div class="social-links mr-4">
                                 <a href="https://facebook.com/dyorindustries" class="social-link social-facebook fab fa-facebook-f"></a>
                                 <a href="https://instagram.com/dyorindustries" class="social-link social-instagram fab fa-instagram"></a>
                                 <a href="https://linkedin.com/company/dyorindustries" class="social-link social-linked-in fab fa-linkedin-in"></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab tab-nav-simple product-tabs">
                     <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active" href="#product-tab-description">Description</a>
                        </li>
                        
                     </ul>
                     <div class="tab-content">
                        <div class="tab-pane active in" id="product-tab-description">
                           <div class="row mt-6">
                              <div class="col-md-6">
                                 <h5 class="description-title mb-4 font-weight-semi-bold ls-m">Description</h5>
                                 <p class="mb-2">
                                    <?php echo $products[0]["product"]["tblProduct_P_LongDescription"];?>
                                 </p>
                              </div>
                              <div class="col-md-6 pl-md-6 pt-4 pt-md-0">
                                 <h5 class="description-title font-weight-semi-bold ls-m mb-5">Video Description</h5>
                                 <figure class="p-relative d-inline-block mb-2">
                                    <img src="images/product/product.jpg" width="559" height="370" alt="Product" />
                                    <a class="btn-play btn-iframe" href="#">
                                    <i class="d-icon-play-solid"></i>
                                    </a>
                                 </figure>
                                 
                              </div>
                           </div>
                        </div>
                    </div>
                  </div>
                  <section class="pt-3 mt-10">
                     <h2 class="title justify-content-center">Related Products</h2>
                     <div class="owl-carousel owl-theme owl-nav-full row cols-2 cols-md-3 cols-lg-4" data-owl-options="{
                        'items': 5,
                        'nav': false,
                        'loop': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                        '0': {
                        'items': 2
                        },
                        '768': {
                        'items': 3
                        },
                        '992': {
                        'items': 4,
                        'dots': false,
                        'nav': true
                        }
                        }
                        }">
                        <?php foreach($products[0]["related_products"] as $p):?>
                           <div class="product-wrap">
                              <div class="product">
                                 <figure class="product-media" style="border: 1px solid #d3986a; border-radius:10px;">
                                    <a href="">
                                    <img src="<?php echo './admin'.ltrim($p['tblImages_R_Product_ImageURL'],'.');?>" alt="product" width="280" height="315" style="border-radius: 10px; max-width: 100%;height: 300px;">
                                    </a>
                                    <div class="product-label-group">
                                       <label class="product-label label-new">new</label>
                                    </div>
                                    
                                    <div class="product-action">
                                       <a href="./productdetails.php?id=<?php echo $p['tblProduct_P_PK']?>" class="btn-product btn-quickview" title="Quick View">
                                       View</a>
                                    </div>
                                 </figure>
                                 <div class="product-details">
                                    <div class="product-cat">
                                        <?php if($p["tblProduct_P_Category"] == '1'):?>
                                            <a href="horeca.php">Ho.Re.Ca</a>
                                        <?php elseif($p["tblProduct_P_Category"] == '2'):?>
                                            <a href="medical.php">Medical</a>
                                        <?php else:?>
                                            <a href="salonspa.php">Salon & Spa</a>
                                        <?php endif;?>
                                    </div>
                                    <h3 class="product-name">
                                       <a href="./productdetails.php?id=<?= $p['tblProduct_P_PK']?>" style="font-weight:600;font-size: 16px;"><?php echo $p["tblProduct_P_Name"];?></a>
                                    </h3>
                                    <!--<div class="product-price">-->
                                    <!--   <ins class="new-price">₹ 199.00</ins><del class="old-price">$210.00</del>-->
                                    <!--</div>-->
                                 </div>
                              </div>
                           </div>
                        <?php endforeach;?>
                     </div>
                  </section>
               </div>
            </div>
         </main>
		 <?php include 'footer.php';?>
      </div>
	  <?php include 'mobilemenu.php';?>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/sticky/sticky.min.js"></script>
      <script src="vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
      <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <script src="vendor/owl-carousel/owl.carousel.min.js"></script>
      <script src="vendor/elevatezoom/jquery.elevatezoom.min.js"></script>
      <script src="vendor/photoswipe/photoswipe.min.js"></script>
      <script src="vendor/photoswipe/photoswipe-ui-default.min.js"></script>
      <script src="js/main.min.js"></script>
   </body>
</html>