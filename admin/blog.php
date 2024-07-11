<?php
session_start();
include('config/db.php');
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>DYOR - Products Add / Edit / Delete</title>
      <!-- Favicons -->
      <link href="img/favicon.png" rel="icon">
      <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
      <!-- Bootstrap core CSS -->
      <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!--external css-->
      <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
      <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
      <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
      <!-- Custom styles for this template -->
      <link href="css/style.css" rel="stylesheet">
      <link href="css/style-responsive.css" rel="stylesheet">
      <script src="lib/chart-master/Chart.js"></script>
      <style>
        

        .action-column {
            width: 100px;
            text-align: center;
        }

        .edit-btn, .delete-btn {
            padding: 8px;
            margin: 2px;
            cursor: pointer;
            border: 1px solid #fff;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }
    </style>
   </head>
   <body>
      <section id="container">
         <?php include 'header.php';?>
         <?php include 'sidebar.php';?>
         <section id="main-content">
            <section class="wrapper">
               <div class="col-lg-12 mt">
               <h3><i class="fa fa-angle-right"></i> Blog Add / Edit / Delete</h3><br/>


               <div class="row content-panel">
                  <div class="panel-heading">
                     <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                           <a data-toggle="tab" href="#add">ADD</a>
                        </li>
                        <li>
                           <a data-toggle="tab" href="#update">Delete</a>
                        </li>
                     </ul>
                  </div>
                  <?php
                      // Check if the success parameter is present in the query string
                      if (isset($_GET['added']) && $_GET['added'] == 1) {
                          echo '<div class="success-message">Blog added successfully!</div>';
                      }
                  ?>
                  <!-- /panel-heading -->
                  <div class="panel-body">
                     <div class="tab-content">
                        <div id="add" class="tab-pane active">
                           <div class="row">
                              <div class="form-panel" style="box-shadow:none;">
                                 <h4 style="text-align:center;">Add Blog Details</h4><br/>

                                 <form enctype="multipart/form-data" role="form" class="form-horizontal" action="controller/process_add_blog.php" method="POST">
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Enter Blog Title :</label>
                                       <div class="col-lg-10">
                                          <input name="title" placeholder="Blog Title" id="Add_txtProductSKU" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">First Paragraph :</label>
                                       <div class="col-lg-10">
                                          <textarea style="resize: vertical;" name="p1" placeholder="Descripiton one" id="Add_txtProductLongDesc" rows="5" class="form-control" required></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Second Paragraph :</label>
                                       <div class="col-lg-10">
                                          <textarea style="resize: vertical;" name="p2" placeholder="Descripiton two" id="Add_txtProductLongDesc" rows="5" class="form-control" required></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Second Header :</label>
                                       <div class="col-lg-10">
                                          <input name="title2" placeholder="Second Header Title" id="Add_txtProductSKU" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Second Header Paragraph :</label>
                                       <div class="col-lg-10">
                                          <textarea style="resize: vertical;" name="secondpara" placeholder="MarkUp Text!" id="Add_txtProductLongDesc" rows="5" class="form-control" required></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Quote :</label>
                                       <div class="col-lg-10">
                                          <input style="resize: vertical;" name="quote" placeholder="MarkUp Text!" id="Add_txtProductLongDesc" rows="5" class="form-control" required></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Tags :</label>
                                       <div class="col-lg-10">
                                          <input name="keywords" placeholder="eg '#keyword1 #keyword2'" id="Add_txtProductKeywords" class="form-control" required>
                                       </div>
                                    </div>
                                 <br/>
                                 <hr style="height: 1px; border-width:0;color:#eff2f7;background-color:#eff2f7;">
                                 <div class="form-panel" style="box-shadow:none;">
                                    <h4 style="text-align:center; margin-top: 50px;">Product Images</h4><br/><br/>
                                    <div class="form-group" style="text-align:center;">
                                       <div class="col-md-6">
                                          <label class="control-label">Select Blog Image Main</label>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="control-label">Select Second Image</label>
                                       </div>
                                       
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-6" style="display:flex;justify-content: center;">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div style="display:flex;justify-content: center; gap: 10px;">
                                                <span class="btn btn-theme02 btn-file" style="background-color: #48bcb4; border-color: #48bcb4;">
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" id="Add_fileProduct_1" class="default" name="image1"/>
                                                </span>
                                                <a href="" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6" style="display:flex;justify-content: center;">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div style="display:flex;justify-content: center; gap: 10px;">
                                                <span class="btn btn-theme02 btn-file" style="background-color: #48bcb4; border-color: #48bcb4;">
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" id="Add_fileProduct_2" class="default" name="image2"/>
                                                </span>
                                                <a href="" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                             </div>
                                          </div>
                                       </div>
                                       
                                       
                                    </div>
                                 </div>
                                 <hr style="height: 1px; border-width:0;color:#eff2f7;background-color:#eff2f7;">
                                 <div class="form-panel" style="box-shadow:none;">
                                    
                                    <div class="form-group" style="margin-top: 50px;">
                                       <div class="col-lg-12">
                                          <div style="display:flex;justify-content: center;"><button class="col-lg-2 btn btn-theme" id="Add_btnRealtedProduct" style="height: 40px;" type="submit">Submit</button></div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                              </div>
                           </div>
                        </div>

                        <!-- UPDATE SECTION -->
                        <div id="update" class="tab-pane">
                           <div class="row">
                              <div class="form-panel" style="box-shadow:none;">
                                 <h4 style="text-align:center;">Delete Blog</h4><br/>
                                    <div class="form-group" style="margin-left:20px">
                                       <label class="col-lg-2 control-label">Search Blog :</label>
                                       <div class="col-lg-8">
                                          <input placeholder="Search Blog by Title" id="Update_txtProductNameSKU" class="form-control">
                                       </div>
                                       <button class="col-lg-1 btn btn-theme" id="Update_btnSearch" type="submit">Search</button>
                                    </div>
                                 <br/><br/><br/>
                                 <h4 style="text-align:center;">Results</h4><br/>

                                 <div id="searchResults">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th>ID</th>
                                             <th>Blog Title</th>
                                             <th>Tags</th>
                                             <th>Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody></tbody>
                                    </table>
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
      <script type="text/javascript" src="lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
      <script>
         

      </script> 
   </body>
</html>