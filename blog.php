<?php 
   include 'admin/config/db.php';

   $sql = "SELECT createdAt, id,title,description_one,imagepath_one  FROM tblblog";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      // Fetch books and store them in an associative array
      $blog = [];
      while ($row = $result->fetch_assoc()) {
        $blog[] = $row;
      }
   }else{
      $blog = [];
   }
   $sql = "SELECT COUNT(*) FROM tblblog";
   $result = $conn->query($sql);
   $data0 = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>DYOR: Blog</title>
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
                     <li>All</li>
                  </ul>
               </div>
            </nav>
            <div class="page-content pb-10 mb-10">
               <div class="container">
                  <ul class="nav-filters filter-underline blog-filters justify-content-center" data-target=".posts">
                     <li><a href="#" class="nav-filter active" data-filter="*">Total Blogs</a><span><?php echo $data0["COUNT(*)"]?></span></li>
                  </ul>
                  <br/>
                  <br/>
                  <div class="posts grid post-grid row" data-grid-options="{
                     'layoutMode': 'fitRows'
                     }">
                     <?php foreach ($blog as $bg):?>
                     <div class="grid-item col-sm-6 col-lg-4 col-xl-3 lifestyle shopping winter-sale">
                        <article class="post">
                           <figure class="post-media overlay-zoom">
                              <a href="post-single.html">
                              <img src=<?php echo $bg['imagepath_one'];?> width="280" height="206" alt="post" />
                              </a>
                           </figure>
                           <div class="post-details">
                              <div class="post-meta">
                                 on <a href="#" class="post-date"><?php echo $bg['createdAt'];?></a>
                                 
                              </div>
                              <h4 class="post-title"><a href=<?php echo "blogpost.php?id=".$bg['id'];?>><?php echo $bg['title'];?></a>
                              </h4>
                              <p class="post-content">
                                 <?php $clippedText = mb_strimwidth($bg['description_one'], 0, 150, '...'); echo $clippedText;?>
                              </p>
                              <a href=<?php echo "blogpost.php?id=".$bg['id'];?> class="btn btn-link btn-underline btn-primary">Read
                              more<i class="d-icon-arrow-right"></i></a>
                           </div>
                        </article>
                     </div>
                  <?php endforeach?>
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
      <script src="vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
      <script src="vendor/isotope/isotope.pkgd.min.js"></script>
      <script src="js/main.min.js"></script>
   </body>
</html>