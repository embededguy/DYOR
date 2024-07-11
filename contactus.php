<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>DYOR: Contact Us</title>
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
   <body class="contact-us">
      <div class="page-wrapper">         
         <?php include 'header.php';?>
         <main class="main">
            <nav class="breadcrumb-nav">
               <div class="container">
                  <ul class="breadcrumb">
                     <li><a href="index.php"><i class="d-icon-home"></i></a></li>
                     <li>Contact Us</li>
                  </ul>
               </div>
            </nav>
            <div class="page-header" style="background-image: url(images/page-header/contact-us.jpg)">
               <h1 class="page-title font-weight-bold text-capitalize ls-l">Contact Us</h1>
            </div>
            <div class="page-content mt-10 pt-7">
               <section class="contact-section">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6 ls-m mb-4">
                           <div class="grey-section d-flex align-items-center h-100">
                              <div>
                                 <h4 class="mb-2 text-capitalize">Headquarters</h4>
                                 <p>Bareja, Ahmedabad, Gujarat, India - 382425;</p>
                                 <h4 class="mb-2 text-capitalize">Phone Number</h4>
                                 <p>
                                    <a href="tel:#">+91 78170 30271</a><br>
                                    <a href="tel:#">+91 97254 56505</a>
                                 </p>
                                 <h4 class="mb-2 text-capitalize">Support</h4>
                                 <p class="mb-4">
                                    <a href="mailto:info@dyorindustries.com"><span class="__cf_email__" >info@dyorindustries.com</span></a><br>
                                    <a href="mailto:dyorindustries@gmail.com"><span class="__cf_email__" >dyorindustries@gmail.com</span></a><br>
                                    <a href="#">Enquiry & Sale</a>
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-6 d-flex align-items-center mb-4">
                           <div class="w-100">
                              <form class="pl-lg-2" action="" method="POST" id="inlineForm">
                                 <h4 class="ls-m font-weight-bold">Let’s Connect</h4>
                                 <p>Your email address will not be published. Required fields are
                                    marked *
                                 </p>
                                 <div class="row mb-2">
                                    <div class="col-12 mb-4">
                                       <textarea class="form-control" placeholder="Message*" name="message" id="message" required></textarea>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                       <input class="form-control" type="text" placeholder="Name *" name="name" id="name" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                       <input class="form-control" type="email" placeholder="Email *" name="email" id="email" required>
                                    </div>
                                 </div>
                                 <button class="btn btn-dark btn-rounded" type="submit">Submit</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>               
               <div>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14706.457505159482!2d72.58271593865048!3d22.853752292054228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e8c4180b88ad5%3A0xd42eb8a34eb8b624!2sBareja%2C%20Gujarat%20382425!5e0!3m2!1sen!2sin!4v1715076156932!5m2!1sen!2sin" frameborder="0" width="100%" height="386px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			   </div>
			   
            </div>
         </main>
		 <?php include 'footer.php';?>
      </div>
	  <?php include 'mobilemenu.php';?>
	  <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('inlineForm');
        
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
        
                var name = document.getElementById('name').value;
                var email = document.getElementById('email').value;
                var message = document.getElementById('message').value;

                var xhr = new XMLHttpRequest();
                var url = './sendmail.php'; // Replace with your server endpoint URL
                var params = 'name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) + '&message=' + encodeURIComponent(message);
                
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Handle successful response from the server
                            console.log('Form submitted successfully');
                            alert("Query Submitted.");
                            // Optionally, you can do something here, such as displaying a success message
                        } else {
                            // Handle errors
                            console.error('Form submission failed');
                            // Optionally, you can display an error message to the user
                        }
                    }
                };
        
                xhr.send(params);
            });
        });
        </script>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
      <script src="js/main.min.js"></script>
   </body>
</html>