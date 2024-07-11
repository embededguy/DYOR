<style>
    
    .widget-body > li > a:hover {
        color: black !important;
    }
</style>
<footer class="footer appear-animate" data-animation-options="{ 'delay': '.2s' }" style="background: !important">
   <div class="footer-middle" style="background:#f7f7f7 !important">
      <div class="container">
         <div class="row">
            <div class="col-lg-3 col-sm-6">
               <div class="widget widget-about">
                  <a href="index.php" class="logo-footer mb-5">
                  <img src="images/demos/demo7/footer-logo.png" alt="logo-footer" width="154" height="43" />
                  </a>
                  <div class="widget-body">
                     <p>DYOR has been at the forefront of hygiene disposable product industry. We are leading manufacturer & supplier, catering diverse sectors with precision & quality.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6">
               <div class="widget">
                  <h4 class="widget-title" style="color:black">Useful Links</h4>
                  <ul class="widget-body">
                     <li><a href="https://dyor.com/">Home</a></li>
                     <li><a href="aboutus.php">About Us</a></li>
                     <li><a href="horeca.php">Ho.Re.Ca.</a></li>
                     <li><a href="medical.php">Medical</a></li>
                     <li><a href="salonspa.php">Salon & Spa</a></li>
                     <!--<li><a href="blog.php">Blog</a></li>-->
					      <li><a href="contactus.php">Contact Us</a></li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-2 col-sm-6">
               <div class="widget mb-6 mb-sm-0">
                  <h4 class="widget-title" style="color:black">Important Reads</h4>
                  <ul class="widget-body">
                     <li><a href="faq.php">FAQ</a></li>
                     <li><a href="#">Terms & Conditions</a></li>
					 <li><a href="#">Shipping & Returns</a></li>
                     <li><a href="#">Disclaimer</a></li>
                     <li><a href="#">Privacy Policy</a></li>
                     <li><a href="#">Payment Options</a></li>
                     <li><a href="#">Sitemap</a></li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="widget">
                  <h4 class="widget-title text-normal" style="color:black">Subscribe to Our Newsletter</h4>
                  <div class="widget-body widget-newsletter">
                     <div class="input-wrapper input-wrapper-inline">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email address here..." required />
                        <button class="btn btn-primary btn-sm btn-icon-right btn-rounded" id="subscribe" type="submit">subscribe<i class="d-icon-arrow-right"></i></button>
                     </div>
                  </div>
               </div>
               <div class="footer-info">
                  <figure class="payment">
                  </figure>
                  <div class="social-links">
                     <a href="https://facebook.com/dyorindustries" class="social-link social-facebook fab fa-facebook-f"></a>
                     <a href="https://instagram.com/dyorindustries" class="social-link social-instagram fab fa-instagram"></a>
                     <a href="https://linkedin.com/company/dyorindustries" class="social-link social-linked-in fab fa-linkedin-in"></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="footer-bottom d-block text-center" style="background:#f7f7f7 !important">
      <p class="copyright">© Copyright <script>document.write(new Date().getFullYear());</script> All rights reserved | Developed & Managed by <a href="https://vhiron.com/" style="text-decoration:none; color:#d3986a;">Vhiron Technologies<a></p>
   </div>
</footer>
<script>
document.getElementById("subscribe").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    var url = "subscribe.php"; // URL to your PHP script that handles the subscription

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert("Subscription successful!");
            } else {
                alert("Subscription failed: " + response.message);
            }
        }
    };

    var email = document.getElementById('email').value;
    var data = JSON.stringify({email: email});

    xhr.send(data);
});
</script>
<a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="d-icon-arrow-up"></i></a>
