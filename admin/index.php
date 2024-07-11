<?php
session_start();
include('config/db.php');

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page if not logged in
    $customPath = "/admin/login.php";
    $actlnk = (empty($_SERVER['HTTPS']) ? 'http' : 'https'). "://$_SERVER[HTTP_HOST]".$customPath ;
    header("Location: $actlnk");
    exit;
}
$sql = "SELECT COUNT(*) FROM tblproduct_p WHERE tblProduct_P_Category = '1'";
$result = $conn->query($sql);
$data0 = mysqli_fetch_assoc($result);

$sql = "SELECT COUNT(*) FROM tblproduct_p WHERE tblProduct_P_Category = '2'";
$result = $conn->query($sql);
$data1 = mysqli_fetch_assoc($result);

$sql = "SELECT COUNT(*) FROM tblproduct_p WHERE tblProduct_P_Category = '3'";
$result = $conn->query($sql);
$data2 = mysqli_fetch_assoc($result);


$sql = "SELECT COUNT(*) FROM tblproduct_p";
$result = $conn->query($sql);
$data3 = mysqli_fetch_assoc($result);

$sql = "SELECT COUNT(*) FROM tblspecification_m";
$result = $conn->query($sql);
$data4 = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>DYOR - Dashboard</title>
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
      <script>
         if (!window.location.pathname.endsWith('/') && !window.location.pathname.endsWith('.php')) {
            // Redirect to the same URL with a trailing slash
            window.location.href = window.location.pathname + '/' + window.location.search + window.location.hash;
         }
      </script>
   </head>
   <body>
      <section id="container">
         <?php include 'header.php';?>
         <?php include 'sidebar.php';?>
         <section id="main-content">
            <section class="wrapper">
               <h3><i class="fa fa-angle-right"></i> Dashboard</h3>
               <div class="row mt col-lg-12">
                  <div class="row">
                     <div class="col-lg-4 col-md-4 col-sm-4 mb" >
                        <div class="weather-3 pn centered" style="background:#2f323a; border-radius: 10px;">
                           <i class="fa fa-glass"></i>
                           <h1><?php echo $data0["COUNT(*)"]; ?></h1>
                           <div class="info" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                              <div class="row">
                                 <h3 class="centered">Ho.Re.Ca.</h3>
                                 <div class="col-sm-3 col-xs-3 pull-right">
                                    <p class="goright"><a href="view_all_products.php?category=1"><i class="fa fa-external-link"></i></a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
					      <div class="col-lg-4 col-md-4 col-sm-4 mb">
                        <div class="weather-3 pn centered" style="background:#2f323a;border-radius: 10px;">
                           <i class="fa fa-medkit"></i>
                           <h1><?php echo $data1["COUNT(*)"]; ?></h1>
                           <div class="info" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                              <div class="row">
                                 <h3 class="centered">Medical</h3>
                                 <div class="col-sm-3 col-xs-3 pull-right">
                                    <p class="goright"><a href="view_all_products.php?category=2"><i class="fa fa-external-link"></i></a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
					      <div class="col-lg-4 col-md-4 col-sm-4 mb">
                        <div class="weather-3 pn centered" style="background:#2f323a;border-radius: 10px;">
                           <i class="fa fa-scissors"></i>
                           <h1><?php echo $data2["COUNT(*)"]; ?></h1>
                           <div class="info" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                              <div class="row">
                                 <h3 class="centered">Salon & Spa</h3>
                                 <div class="col-sm-3 col-xs-3 pull-right">
                                    <p class="goright"><a href="view_all_products.php?category=3"><i class="fa fa-external-link"></i></a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-lg-4 col-md-4 col-sm-4 mb" >
                        <div class="weather-3 pn centered" style="background:#2f323a; border-radius: 10px;">
                           <i class="fa fa-database"></i>
                           <h1><?php echo $data3["COUNT(*)"]; ?></h1>
                           <div class="info" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                              <div class="row">
                                 <h3 class="centered">Products</h3>
                                 
                                 <div class="col-sm-3 col-xs-3 pull-right">
                                    <p class="goright"><a href="view_all_products.php"><i class="fa fa-external-link"></i></a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 mb">
                        <div class="weather-3 pn centered" style="background:#2f323a;border-radius: 10px;">
                           <i class="fa fa-database"></i>
                           <h1><?php echo $data4["COUNT(*)"]; ?></h1>
                           <div class="info" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                              <div class="row">
                                 <h3 class="centered">Specifications</h3>
                                 
                                 <div class="col-sm-6 col-xs-6 pull-right">
                                    <p class="goright"><a href="view_all_spec.php"><i class="fa fa-external-link"></i></a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                  </div>
               </div>

            </section>
         </section>
      </section>
      <!-- js placed at the end of the document so the pages load faster -->
      <script src="lib/jquery/jquery.min.js"></script>
      <script src="lib/bootstrap/js/bootstrap.min.js"></script>
      <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
      <script src="lib/jquery.scrollTo.min.js"></script>
      <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
      <script src="lib/jquery.sparkline.js"></script>
      <!--common script for all pages-->
      <script src="lib/common-scripts.js"></script>
      <script type="text/javascript" src="lib/gritter/js/jquery.gritter.js"></script>
      <script type="text/javascript" src="lib/gritter-conf.js"></script>
      <!--script for this page-->
      <script src="lib/sparkline-chart.js"></script>
      <script src="lib/zabuto_calendar.js"></script>
   </body>
</html>