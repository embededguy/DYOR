<?php 
   include('admin/config/db.php');
   $display_product_ids1 = "18,23,29,39,50,59";
   $display_product_ids2 = "68,78,73,62";
   
   $query = "SELECT * FROM `tblproduct_p` WHERE tblProduct_P_PK IN ($display_product_ids1)";
   $result = $conn->query($query);
   $products1 = array();
   $products2 = array();
   $products3 = array();
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

    $products1[] = $product;
}

$query = "SELECT * FROM `tblproduct_p` WHERE tblProduct_P_PK IN ($display_product_ids2)";
$result = $conn->query($query);
   
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
    $products2[] = $product;
}
   
$query = "SELECT * FROM `tblproduct_p` WHERE tblProduct_P_PK = 81";
$result = $conn->query($query);

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
    $products3[] = $product;
}


?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>DYOR: Home</title>
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
      <link rel="preload" href="fonts/riode115b.ttf?5gap68" as="font" type="font/woff2" crossorigin="anonymous">
      <link rel="preload" href="vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin="anonymous">
      <link rel="preload" href="vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
      <script>
         WebFontConfig = {
             google: { families: ['Poppins:400,500,600,700,800,900'] }
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
      <link rel="stylesheet" type="text/css" href="vendor/sticky-icon/stickyicon.css">
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
   <body class="home">
      <div class="page-wrapper">
         <h1 class="d-none">Riode - Responsive eCommerce HTML Template</h1>
         <?php include 'header.php';?>
         <main class="main">
            <div class="page-content">
               <section class="intro-section">
                  <div class="owl-carousel owl-theme row owl-nav-arrow owl-nav-fade  intro-slider mb-2 animation-slider cols-1 gutter-no" data-owl-options="{
                     'nav': false,
                     'dots': false,
                     'loop': false,
                     'items': 1,
                     'autoplay': false,
                     'responsive': {
                     '992': {
                     'nav': true
                     }
                     }
                     }">
                     <div class="banner banner-fixed intro-slide1">
                        <figure>
                           <img src="images/demos/demo7/slides/1.jpg" alt="intro-banner" width="1903" height="912" style="background-color: #f3f3f3" />
                        </figure>
                        <div class="container">
                           <div class="banner-content y-50 d-block d-lg-flex align-items-center">
                              <div class="banner-content-left slide-animate" data-animation-options="{
                                 'name': 'fadeInLeftShorter', 'duration': '1s'
                                 }">
                                 <h4 class="banner-subtitle text-uppercase text-white">Ho.Re.Ca</h4>
                                 <h3 class="banner-title text-uppercase text-white">Essentials</h3>
                              </div>
                              <div class="banner-content-right ml-lg-auto slide-animate" data-animation-options="{
                                 'name': 'fadeInRightShorter', 'duration': '1s'
                                 }">
                                 <h4 class="banner-subtitle text-primary text-uppercase font-weight-bold">Best Quality</h4>
                                 <h3 class="banner-title text-uppercase text-white font-weight-bold mb-6">Transforming assistance for perfection</h3>
                                 <a href="./horeca.php" class="btn btn-dark btn-rounded">Order Now<i class="d-icon-arrow-right"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="banner banner-fixed intro-slide1">
                        <figure>
                           <img src="images/demos/demo7/slides/2.jpg" alt="intro-banner" width="1903" height="912" style="background-color: #f3f3f3" />
                        </figure>
                        <div class="container">
                           <div class="banner-content y-50 d-block d-lg-flex align-items-center">
                              <div class="banner-content-left slide-animate" data-animation-options="{
                                 'name': 'fadeInLeftShorter', 'duration': '1s'
                                 }">
                                 <h4 class="banner-subtitle text-uppercase text-white">Medical</h4>
                                 <h3 class="banner-title text-uppercase text-white">Sterile</h3>
                              </div>
                              <div class="banner-content-right ml-lg-auto slide-animate" data-animation-options="{
                                 'name': 'fadeInRightShorter', 'duration': '1s'
                                 }">
                                 <h4 class="banner-subtitle text-primary text-uppercase font-weight-bold">Best Standards</h4>
                                 <h3 class="banner-title text-uppercase text-white font-weight-bold mb-6">Superior protection for excellence</h3>
                                 <a href="./salonspa.php" class="btn btn-dark btn-rounded">Order Now<i class="d-icon-arrow-right"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="banner banner-fixed intro-slide1">
                        <figure>
                           <img src="images/demos/demo7/slides/3.jpg" alt="intro-banner" width="1903" height="912" style="background-color: #f3f3f3" />
                        </figure>
                        <div class="container">
                           <div class="banner-content y-50 d-block d-lg-flex align-items-center">
                              <div class="banner-content-left slide-animate" data-animation-options="{
                                 'name': 'fadeInLeftShorter', 'duration': '1s'
                                 }">
                                 <h4 class="banner-subtitle text-uppercase text-white">Salon & Spa</h4>
                                 <h3 class="banner-title text-uppercase text-white">Rejuvenation</h3>
                              </div>
                              <div class="banner-content-right ml-lg-auto slide-animate" data-animation-options="{
                                 'name': 'fadeInRightShorter', 'duration': '1s'
                                 }">
                                 <h4 class="banner-subtitle text-primary text-uppercase font-weight-bold">Best Designs</h4>
                                 <h3 class="banner-title text-uppercase text-white font-weight-bold mb-6">Concealed layers for finesse</h3>
                                 <a href="./salonspa.php" class="btn btn-dark btn-rounded">Order Now<i class="d-icon-arrow-right"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="category-wrap row cols-lg-4 cols-sm-2 cols-1 gutter-sm">
                     <div class="category category-absolute category-banner appear-animate mb-2" data-animation-options="{
                        'name': 'fadeInLeftShorter',
                        'delay': '.4s'
                        }">
                        <a href="#">
                           <figure class="category-media">
                              <img src="images/demos/demo7/categories/1.jpg" alt="category" width="468" height="320" />
                           </figure>
                        </a>
                        <div class="category-content align-items-center x-50 w-100" style="color:white !important">
                           <h4 class="category-name text-uppercase" style="color:white !important">Non-Woven Products</h4>
                           <span class="category-count text-uppercase">
                           </span>
                           <a href="./searchresult.php?query=PP,SBPP,SMS" class="btn btn-white btn-underline btn-link">Order Now</a>
                        </div>
                     </div>
                     <div class="banner banner-fixed overlay-effect1 appear-animate mb-2" data-animation-options="{
                        'name': 'fadeInLeftShorter',
                        'delay': '.2s'
                        }">
                        <a href="#">
                           <figure class="category-media">
                              <img src="images/demos/demo7/categories/2.jpg" alt="category" width="468" height="320" style="background-color: rgb(43, 43, 35);" />
                           </figure>
                        </a>
                        <div class="banner-content text-center x-50 y-50 w-100">
                           <h4 class="banner-subtitle text-uppercase text-primary font-weight-bold">Disposable</h4>
                           <h3 class="banner-title text-white ls-m">Plastic Products</h3>
                           <p class="font-weight-semi-bold"><br/></p>
                           <a href="./searchresult.php?query=PE" class="btn btn-white btn-link btn-underline">Order Now<i class="d-icon-arrow-right"></i></a>
                        </div>
                     </div>
                     <div class="category category-absolute category-banner appear-animate mb-2" data-animation-options="{
                        'name': 'fadeInRightShorter',
                        'delay': '.2s'
                        }">
                        <a href="#">
                           <figure class="category-media">
                              <img src="images/demos/demo7/categories/3.jpg" alt="category" width="468" height="320" />
                           </figure>
                        </a>
                        <div class="category-content align-items-center x-50 w-100">
                           <h4 class="category-name text-uppercase" style="color:white !important">Aluminium Products</h4>
                           <span class="category-count text-uppercase">
                           </span>
                           <a href="./searchresult.php?query=aluminium" class="btn btn-white btn-underline btn-link x-50">Order Now</a>
                        </div>
                     </div>
                     <div class="banner banner-fixed overlay-effect1 appear-animate mb-2" data-animation-options="{
                        'name': 'fadeInRightShorter',
                        'delay': '.4s'
                        }">
                        <a href="#">
                           <figure class="category-media">
                              <img src="images/demos/demo7/categories/4.jpg" alt="category" width="468" height="320" style="background-color: rgb(196, 140, 92);" />
                           </figure>
                        </a>
                        <div class="banner-content text-center x-50 y-50 w-100">
                           <h4 class="banner-subtitle text-uppercase text-primary font-weight-bold" >Multipurpose</h4>
                           <h3 class="banner-title text-white ls-m" style="color:white !important">Paper Products</h3>
                           <p class="font-weight-semi-bold text-white"><br/></p>
                           <a href="./searchresult.php?query=paper" class="btn btn-white btn-link btn-underline">Order Now<i class="d-icon-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </section>
               <section class="mt-10 pt-7 appear-animate" data-animation-options="{
                  'delay': '.2s'
                  }">
                  <div class="container">
                     <h2 class="title title-center">Best Sellers</h2>
                     <div class="row">
                        <?php foreach ($products1 as $p) :?> 
                        <div class="col-lg-4 col-6 mb-4">
                           <div class="product text-center">
                              <figure class="product-media" style="border: 1px solid #d3986a; border-radius:10px; flex: 1 0 0; overflow: hidden;">
                                    <img src="<?php echo './admin'.ltrim($p['images'][0]['tblImages_R_Product_ImageURL'],'.');?>" alt="product" style="border-radius: 10px; width: 500px; height:345px; object-fit: contain;">
                                    <div class="product-label-group">
                                        <label class="product-label label-new">best seller</label>
                                    </div>
                                    <div class="product-action">
                                        <a href="./productdetails.php?id=<?= $p['product']['tblProduct_P_PK']?>" class="btn-product btn-quickview" title="Quick View">View</a>
                                    </div>
                                </figure>
                              <div class="product-details">
                                 <div class="product-cat">
                                    <?php if($p['product']['tblProduct_P_Category'] == '1'):?>
                                        <a href="horeca.php">Ho.Re.Ca</a>
                                    <?php elseif($p['product']['tblProduct_P_Category'] == '2'):?>
                                        <a href="medical.php">Medical</a>
                                    <?php elseif($p['product']['tblProduct_P_Category'] == '3'):?>
                                        <a href="salonspa.php">Salon & SPA</a>
                                    <?php endif;?>
                                 </div>
                                 <h3 class="product-name">
                                    <a href="./productdetails.php?id=<?= $p['product']['tblProduct_P_PK']?>"><?php echo $p["product"]["tblProduct_P_Name"];?></a>
                                 </h3>
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
               </section>
               <section class="banner-group pt-2 mt-10">
                  <div class="row cols-md-2 gutter-sm">
                     <div class="banner banner-fixed overlay-light overlay-zoom appear-animate">
                        <figure>
                           <img src="images/demos/demo7/banners/1.jpg" width="945" height="390" alt="banner" style="background-color: rgb(37, 38, 39);" />
                        </figure>
                        <div class="banner-content y-50">
                           <div class="appear-animate" data-animation-options="{
                              'name': 'fadeInUpShorter',
                              'delay': '.2s'
                              }">
                              <h4 class="banner-subtitle text-uppercase text-primary font-weight-bold">
                                 HoReCa
                              </h4>
                              <h3 class="banner-title text-white font-weight-bold mb-3">Essentials that help you Shine</h3>
                              <p class="font-weight-semi-bold mb-6"></br></p>
                              <a href="horeca.php" class="btn btn-primary btn-rounded">Order Now<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="banner banner-fixed overlay-dark overlay-zoom appear-animate">
                        <figure>
                           <img src="images/demos/demo7/banners/2.jpg" width="945" height="390" alt="banner" style="background-color: rgb(236, 237, 239);" />
                        </figure>
                        <div class="banner-content y-50">
                           <div class="appear-animate" data-animation-options="{
                              'name': 'fadeInUpShorter',
                              'delay': '.3s'
                              }">
                              <h4 class="banner-subtitle text-uppercase text-primary font-weight-bold">
                                 Medical
                              </h4>
                              <h3 class="banner-title text-white font-weight-bold mb-3">Sterile & Safety at every step</h3>
                              <p class="font-weight-semi-bold mb-6 text-body"></br></p>
                              <a href="./medical.php" class="btn btn-primary btn-rounded">Order Now<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
               <section class="mt-10 pt-7 appear-animate" data-animation-options="{
                  'delay': '.2s'
                  }">
                  <div class="container">
                     <h2 class="title title-center mb-6">Featured Item</h2>
                     <div class="product product-single row pt-4">
                        <div class="col-md-6 product-gallery">
                           <div class="rotate-slider owl-carousel product-single-carousel owl-theme owl-nav-arrow row gutter-no cols-1" data-owl-options="{
                              'nav': true,
                              'dots': false,
                              'loop': true
                              }">
                              <?php foreach ($products3[0]["images"] as  $p):?>
                              <figure class="product-image" style="background:white">
                                 <img src="<?php echo './admin'.ltrim($p['tblImages_R_Product_ImageURL'],'.');?>" data-zoom-image="<?php echo './admin'.ltrim($p['tblImages_R_Product_ImageURL'],'.');?>" alt="Featured Item" style="object-fit:scale-down; height:500px">
                              </figure>
                              <?php endforeach?>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="product-details">
                              <h2 class="product-name">
                                 <a href=""><?php echo $products3[0]["product"]["tblProduct_P_Name"];?></a>
                              </h2>
                              <div class="product-meta mb-3">
                                 SKU: <span class="product-sku"><?php echo $products3[0]["product"]["tblProduct_P_SKU"];?></span>
                                 CATEGORY: <span class="product-cat text-capitalize">Salon & SPA</span>
                              </div>
                              <h5 class="product-name">
                                 <a href="">Colors</a>
                              </h5>
                              <div class="product-variations">
                              <?php foreach ( $products3[0]["colors"] as $p ):?>
                                <a class="color" href="" style="border: 1px solid grey; border-radius:5px; background-color: <?php echo $p['tblColor_ColorName'];?>"></a>
							  <?php endforeach;?>
                              </div>
                              <hr class="product-divider mb-3">
                              <h5 class="product-name">
                                 <a href="">Description</a>
                              </h5>
                              <p class="product-short-desc font-primary">
                                 <?php echo $products3[0]["product"]["tblProduct_P_ShortDescription"];?>
                              </p>
                              
                              <hr class="product-divider mb-3">
                              <div id="product-tab-description">
                              <table class="table">
                                    <tbody>
                                       <?php foreach($products3[0]["specifications"] as $p):?>
                                           <tr>
                                              <th class="font-weight-semi-bold text-dark pl-0"><?php echo $p["tblSpecification_Name"];?></th>
                                              <td class="pl-4"><?php echo $p["tblSpecification_R_Product_SpecificationValue"];?></td>
                                           </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                </table>
                            <br/><br/>
                           <div class="product-footer">
                              <div class="social-links mr-4">
                                 <a href="https://facebook.com/dyorindustries" class="social-link social-facebook fab fa-facebook-f"></a>
                                 <a href="https://instagram.com/dyorindustries" class="social-link social-twitter fab fa-instagram"></a>
                                 <a href="https://linkedin.com/company/dyorindustries" class="social-link social-pinterest fab fa-linkedin-in"></a>
                              </div>
                           </div>
                            </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section><br/><br/>
               <section class="mt-7 appear-animate" data-animation-options="{
                  'delay': '.2s'
                  }">
                  <div class="container">
                     <h2 class="title title-center">Trending Now</h2><br/>
                     <div class="owl-carousel owl-theme row owl-nav-full owl-shadow-carousel cols-lg-4 cols-md-3 cols-2" data-owl-options="{
                        'items': 4,
                        'nav': false,
                        'dots': true,
                        'loop': false,
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
                        'nav': true,
                        'dots': false
                        }
                        }
                        }">
                        <?php foreach ($products2 as $p) :?>
                        <div class="product text-center">
                           <figure class="product-media" style="border: 1px solid #d3986a; border-radius:10px; flex: 1 0 0; overflow: hidden;">
                                <img src="<?php echo './admin'.ltrim($p['images'][0]['tblImages_R_Product_ImageURL'],'.');?>" alt="product" style="border-radius: 10px; width: 500px; height:345px; object-fit: contain;">
                                <div class="product-label-group">
                                    <label class="product-label label-new">trending</label>
                                </div>
                                <div class="product-action">
                                    <a href="./productdetails.php?id=<?= $p['product']['tblProduct_P_PK']?>" class="btn-product btn-quickview" title="Quick View">View</a>
                                </div>
                            </figure>
                           <div class="product-details">
                             <div class="product-cat">
                                <?php if($p['product']['tblProduct_P_Category'] == '1'):?>
                                    <a href="horeca.php">Ho.Re.Ca</a>
                                <?php elseif($p['product']['tblProduct_P_Category'] == '2'):?>
                                    <a href="medical.php">Medical</a>
                                <?php elseif($p['product']['tblProduct_P_Category'] == '3'):?>
                                    <a href="salonspa.php">Salon & SPA</a>
                                <?php endif;?>
                             </div>
                             <h3 class="product-name">
                                <a href="./productdetails.php?id=<?= $p['product']['tblProduct_P_PK']?>"><?php echo $p["product"]["tblProduct_P_Name"];?></a>
                             </h3>
                             <div class="available-colors">
                                <ul class="color-list">
                                    <?php foreach($p['colors'] as $c):?>
                                    <li><a href="#" style="background-color: <?php echo $c['tblColor_ColorName'];?>"></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                          </div>
                        </div>
                        <?php endforeach?>
                     </div>
                  </div>
               </section>
               <br/>
               <section class="mt-10 pt-6" style="display:none">
                  <div class="container">
                     <h2 class="title title-center">From Our Blog</h2>
                     <div class="owl-carousel owl-theme row cols-xl-4 cols-lg-3 cols-sm-2 cols-1" data-owl-options="{
                        'items': 4,
                        'dots': true,
                        'nav': false,
                        'loop': false,
                        'margin': 20,
                        'autoPlay': true,
                        'responsive': {
                        '0': {
                        'items': 1
                        },
                        '576': {
                        'items': 2
                        },
                        '992': {
                        'items': 3
                        },
                        '1200': {
                        'items': 4,
                        'dots': false
                        }
                        }
                        }">
                        <div class="post overlay-dark overlay-zoom appear-animate" data-animation-options="{
                           'name': 'fadeInRightShorter',
                           'delay': '.2s'
                           }">
                           <figure class="post-media">
                              <a href="post-single.html">
                              <img src="images/demos/demo7/blog/1.jpg" width="370" height="255" alt="post" />
                              </a>
                           </figure>
                           <div class="post-details">
                              <div class="post-meta">
                                 on <a href="#" class="post-date">September 27, 2020</a>
                                 | <a href="#" class="post-comment"><span>2</span> Comments</a>
                              </div>
                              <h4 class="post-title"><a href="post-single.html">Just a cool blog post with
                                 Images</a>
                              </h4>
                              <p class="post-content">Londi m velnond ec tellus mass. facilisis
                                 quissapienfacilisis quis sapien.
                              </p>
                              <a href="post-single.html" class="btn btn-link btn-underline btn-primary btn-md">Read
                              More<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </div>
                        <div class="post overlay-dark overlay-zoom appear-animate" data-animation-options="{
                           'name': 'fadeInRightShorter',
                           'delay': '.3s'
                           }">
                           <figure class="post-media">
                              <a href="post-single.html">
                              <img src="images/demos/demo7/blog/2.jpg" width="370" height="255" alt="post" />
                              </a>
                           </figure>
                           <div class="post-details">
                              <div class="post-meta">
                                 on <a href="#" class="post-date">September 27, 2020</a>
                                 | <a href="#" class="post-comment"><span>2</span> Comments</a>
                              </div>
                              <h4 class="post-title"><a href="post-single.html">Just a cool blog post with
                                 Images</a>
                              </h4>
                              <p class="post-content">Londi m velnond ec tellus mass. facilisis
                                 quissapienfacilisis quis sapien.
                              </p>
                              <a href="post-single.html" class="btn btn-link btn-underline btn-primary btn-md">Read
                              More<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </div>
                        <div class="post overlay-dark overlay-zoom appear-animate" data-animation-options="{
                           'name': 'fadeInRightShorter',
                           'delay': '.4s'
                           }">
                           <figure class="post-media">
                              <a href="post-single.html">
                              <img src="images/demos/demo7/blog/3.jpg" width="370" height="255" alt="post" />
                              </a>
                           </figure>
                           <div class="post-details">
                              <div class="post-meta">
                                 on <a href="#" class="post-date">September 27, 2020</a>
                                 | <a href="#" class="post-comment"><span>2</span> Comments</a>
                              </div>
                              <h4 class="post-title"><a href="post-single.html">Just a cool blog post with
                                 Images</a>
                              </h4>
                              <p class="post-content">Londi m velnond ec tellus mass. facilisis
                                 quissapienfacilisis quis sapien.
                              </p>
                              <a href="post-single.html" class="btn btn-link btn-underline btn-primary btn-md">Read
                              More<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </div>
                        <div class="post overlay-dark overlay-zoom appear-animate" data-animation-options="{
                           'name': 'fadeInRightShorter',
                           'delay': '.5s'
                           }">
                           <figure class="post-media">
                              <a href="post-single.html">
                              <img src="images/demos/demo7/blog/4.jpg" width="370" height="255" alt="post" />
                              </a>
                           </figure>
                           <div class="post-details">
                              <div class="post-meta">
                                 on <a href="#" class="post-date">September 27, 2020</a>
                                 | <a href="#" class="post-comment"><span>2</span> Comments</a>
                              </div>
                              <h4 class="post-title"><a href="post-single.html">Just a cool blog post with
                                 Images</a>
                              </h4>
                              <p class="post-content">Londi m velnond ec tellus mass. facilisis
                                 quissapienfacilisis quis sapien.
                              </p>
                              <a href="post-single.html" class="btn btn-link btn-underline btn-primary btn-md">Read
                              More<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
               <br/>
               <br/>
               <br/>
               <br/>

            </div>
         </main>
		 <?php include 'footer.php';?>
      </div>
      <?php include 'mobilemenu.php';?>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
      <script src="vendor/elevatezoom/jquery.elevatezoom.min.js"></script>
      <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <script src="vendor/owl-carousel/owl.carousel.min.js"></script>
      <script src="vendor/jquery.plugin/jquery.plugin.min.js"></script>
      <script src="vendor/jquery.countdown/jquery.countdown.min.js"></script>
      <script src="js/main.min.js"></script>
   </body>
</html>