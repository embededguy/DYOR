<?php
   include 'admin/config/db.php';
   $id = isset($_GET['id']) ? $_GET['id'] : 0;   
   $sql = "SELECT * FROM tblblog WHERE id = $id";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      $blog = $result->fetch_assoc();
   }

   $words = explode(' ', $blog['tags']);

   $sql = "SELECT * FROM tblblog WHERE tags LIKE '%popular%' LIMIT 3";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $popular = [];
      while ($row = $result->fetch_assoc()) {
        $popular[] = $row;
      }
   }else{
      $popular = [];
   }
   $tgs = $blog['tags'];

   $sql = "SELECT * FROM tblblog WHERE tags LIKE '%$tgs%' LIMIT 3";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $related = [];
      while ($row = $result->fetch_assoc()) {
        $related[] = $row;
      }
   }else{
      $related = [];
   }

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>DYOR: <?php echo $blog['title'];?></title>
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
      <link rel="stylesheet" type="text/css" href="vendor/sticky-icon/stickyicon.css">
      <link rel="stylesheet" type="text/css" href="css/style.min.css">
	  <link rel="stylesheet" type="text/css" href="css/demo7.min.css">
   </head>
   <body>
      <div class="page-wrapper">         
         <?php include 'header.php';?>
         <main class="main">
            <nav class="breadcrumb-nav">
               <div class="container">
                  <ul class="breadcrumb">
                     <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                     <li><a href="#" class="active">Blog</a></li>
                     <li>Blog Post</li>
                  </ul>
               </div>
            </nav>
            <div class="page-content with-sidebar">
               <div class="container">
                  <div class="row gutter-lg">
                     <div class="col-lg-9">
                        <article class="post-single">
                           <figure class="post-media">
                              <a href="#">
                              <img src=<?php echo $blog['imagepath_one'];?> width="880" height="450" alt="post" />
                              </a>
                           </figure>
                           <div class="post-details">
                              <div class="post-meta">
                                 Date : <a href="#" class="post-date"><?php echo $blog['createdAt'];?></a>
                                 
                              </div>
                              <h4 class="post-title"><a href="#"><?php echo $blog['title'];?></a>
                              </h4>
                              <div class="post-body mb-7">
                                 <p class="mb-5"><?php echo $blog['description_one'];?>
                                 </p>
                                 <p class="mb-6"><?php echo $blog['description_two'];?>
                                 </p>
                                 <div class="with-img row align-items-center">
                                    <div class="col-md-6 mb-6">
                                       <figure>
                                          <img src=<?php echo $blog['imagepath_two'];?> alt="image" width="336" height="415" class="float-left">
                                          <figcaption class="text-left mt-1">
                                          </figcaption>
                                       </figure>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                       <h4 class="font-weight-semi-bold ls-s"><?php echo $blog['header_two'];?></h4>
                                       <p class="mb-8 col-lg-11"><?php echo $blog['paragraph_two'];?>
                                       </p>                                       
                                    </div>
                                 </div>
                                 <blockquote class="mt-1 mb-6 p-relative">
                                    <p class="font-weight-semi-bold ls-m">
                                       “ <?php echo $blog['quote'];?> ”
                                    </p>
                                 </blockquote>
                              </div>
                                                          
                           </div>
                        </article>
                        <div class="related-posts">
                           <h3 class="title title-simple text-left text-normal font-weight-bold ls-normal">Related
                              Posts
                           </h3>
                           <div class="owl-carousel owl-theme row cols-lg-3 cols-sm-2" data-owl-options="{
                              'items': 1,
                              'margin': 20,
                              'loop': false,
                              'responsive': {
                              '576': {
                              'items': 2
                              },
                              '768': {
                              'items': 3
                              }
                              }
                              }">
                              <?php foreach ($related as $rel): ?>
                              <?php 
                                 $str = explode(" ", $rel['createdAt'])[0];
                                 $date = new DateTime($str);
                                 $year = $date->format('Y');
                                 $month = strtoupper($date->format('M'));
                                 $day = $date->format('d');

                              ?>
                              <div class="post">
                                 <figure class="post-media">
                                    <a href="#">
                                    <img src=<?php echo $blog['imagepath_one'];?> width="380" height="250" alt="post" />
                                    </a>
                                    <div class="post-calendar">
                                       <span class="post-day"><?php echo $day;?></span>
                                       <span class="post-month"><?php echo $month;?></span>
                                    </div>
                                 </figure>
                                 <div class="post-details">
                                    <h4 class="post-title"><a href="post-single.html"><?php echo $rel["title"]?></a>
                                    </h4>
                                    <p class="post-content">
                                       <?php $clippedText = mb_strimwidth($rel['description_one'], 0, 150, '...'); echo $clippedText;?>
                                    </p>
                                    <a href=<?php echo "blogpost.php?id=".$rel['id'];?> class="btn btn-link btn-underline btn-primary">Read more<i class="d-icon-arrow-right"></i></a>
                                 </div>
                              </div>
                                 
                              <?php endforeach ?>
                              
                           </div>
                        </div>
                     </div>
                     <aside class="col-lg-3 right-sidebar sidebar-fixed sticky-sidebar-wrapper">
                        <div class="sidebar-overlay"></div>
                        <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
                        <a href="#" class="sidebar-toggle"><i class="fas fa-chevron-left"></i></a>
                        <div class="sidebar-content">
                           <div class="sticky-sidebar" data-sticky-options="{'top': 89, 'bottom': 70}">
                                                            
                              <div class="widget widget-collapsible">
                                 <h3 class="widget-title">Popular Posts</h3>
                                 <div class="widget-body">
                                    <div class="post-col">
                                       <?php foreach ($popular as $pop): ?>
                                       <div class="post post-list-sm">
                                          <figure class="post-media">
                                             <a href="post-single.html">
                                             <img src=<?php echo $pop['imagepath_one']?> width="90" height="90" alt="post" />
                                             </a>
                                          </figure>
                                          <div class="post-details">
                                             <div class="post-meta">
                                                <a href="#" class="post-date"><?php echo $pop['createdAt']?></a>
                                             </div>
                                             <h4 class="post-title"><a href=<?php echo "blogpost.php?id=".$pop['id'];?>><?php echo $pop['title']?></a>
                                             </h4>
                                          </div>
                                       </div>
                                          
                                       <?php endforeach ?>
                                       
                                    </div>
                                 </div>
                              </div>
                              <div class="widget widget-posts widget-collapsible">
                                 <h3 class="widget-title">Tag Cloud</h3>
                                 <div class="widget-body">
                                    <?php foreach ($words as $val): ?>
                                       <a href="" class="tag"><?php echo $val;?></a>
                                    <?php endforeach ?>
                                    
                                 </div>
                              </div>
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
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/sticky/sticky.min.js"></script>
      <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <script src="vendor/owl-carousel/owl.carousel.min.js"></script>
      <script src="js/main.min.js"></script>
   </body>
</html>