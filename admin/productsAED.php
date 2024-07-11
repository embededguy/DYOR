<?php
session_start();
include('config/db.php');
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

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
               <h3><i class="fa fa-angle-right"></i> Product Add / Edit / Delete</h3><br/>


               <div class="row content-panel">
                  <div class="panel-heading">
                     <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                           <a data-toggle="tab" href="#add">ADD</a>
                        </li>
                        <li>
                           <a data-toggle="tab" href="#update">Edit / Delete</a>
                        </li>
                     </ul>
                  </div>
                  <?php
                      // Check if the success parameter is present in the query string
                      if (isset($_GET['added']) && $_GET['added'] == 1) {
                          echo '<div class="success-message">Product added successfully!</div>';
                      }
                  ?>
                  <?php
                      // Check if the success parameter is present in the query string
                      if (isset($_GET['edited']) && $_GET['edited'] == 1) {
                          echo '<div class="success-message">Product edited successfully!</div>';
                      }
                  ?>
                  <?php
                      // Check if the success parameter is present in the query string
                      if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
                          echo '<div class="success-message">Product Deleted successfully!</div>';
                      }
                  ?>
                  <!-- /panel-heading -->
                  <div class="panel-body">
                     <div class="tab-content">
                        <div id="add" class="tab-pane active">
                           <div class="row">
                              <div class="form-panel" style="box-shadow:none;">
                                 <h4 style="text-align:center;">Add Product Details</h4><br/>

                                 <form enctype="multipart/form-data" role="form" class="form-horizontal" action="controller/process_add_product.php" method="POST">
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Enter Product SKU :</label>
                                       <div class="col-lg-10">
                                          <input name="sku" placeholder="Max 8 Characters!" id="Add_txtProductSKU" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Enter Product Name :</label>
                                       <div class="col-lg-10">
                                          <input name="pname" placeholder="Max 60 Characters!" id="Add_txtProductName" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Product Category :</label>
                                       <div class="col-lg-10">
                                          <select name="category" placeholder="" id="Add_slctProductCategory" class="form-control">
                                             <option value="0">-- Select Category --</option>
                                             <option value="1">Ho.Re.Ca.</option>
                                             <option value="2">Medical</option>
                                             <option value="3">Salon & Spa</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Short Description :</label>
                                       <div class="col-lg-10">
                                          <input name="shortdesc" placeholder="Max 160 Characters!" id="Add_txtProductShortDesc" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Long Description :</label>
                                       <div class="col-lg-10">
                                          <textarea style="resize: vertical;" name="longdesc" placeholder="MarkUp Text!" id="Add_txtProductLongDesc" rows="5" class="form-control"></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Meta KeyWords :</label>
                                       <div class="col-lg-10">
                                          <input name="keywords" placeholder="eg '#keyword1 #keyword2'" id="Add_txtProductKeywords" class="form-control">
                                       </div>
                                    </div>
                                 <br/>
                                 <hr style="height: 1px; border-width:0;color:#eff2f7;background-color:#eff2f7;">
                                 <div class="form-panel" style="box-shadow:none;">
                                    <h4 style="text-align:center;">Product Colors</h4><br/>
                                    <div class="form-group">
                                       <input type="hidden" name="selectedColors" id="selectedColors" value="">
                                       <label class="col-lg-2 control-label">Select Color(s) :</label>
                                       <div class="col-lg-6">
                                          <select placeholder="" id="Add_slctProductColor" class="form-control">
                                             <option value="" selected>-- Please Select a Color Code --</option>
                                                <?php
                                                     // Display subjects as options in the select element
                                                   foreach ($color_all as $spec) {
                                                      $specname = $spec['tblColor_ColorName'];
                                                      $specid = $spec['tblColor_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                                ?>
                                          </select>
                                       </div>
                                       <a class="col-lg-2 btn btn-theme" id="add_color">Add Color</a>		
                                       <a class="col-lg-1 btn btn-theme" id="clear" style="margin-left: 10px;">Clear</a>
                                    </div>
                                    <br/>
                                    <div class="col-lg-12" id="wtc" style="margin-top:0px;gap:10px;display:flex; justify-content: center;align-items: center;flex-wrap: wrap;">
                                       
                                    </div>
                                    click on color to delete it*
                                    <br/><br/>
                                 </div>
                                 <br/>
                                 <div class="form-panel" style="box-shadow:none;">
                                    <h4 style="text-align:center;">Product Specifications</h4><br/>
                                    <div class="form-group" style="text-align:center;">
                                       <div class="col-md-4">
                                          <label class="control-label">Select Product Specification 1</label>
                                       </div>
                                       
                                       <div class="col-md-4">
                                          <label class="control-label">Select Product Specification 2</label>
                                       </div>
                                       
                                       <div class="col-md-4">
                                          <label class="control-label">Select Product Specification 3</label>
                                       </div>
                                    </div>
                                    <br/>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <select placeholder="" id="Add_slctProductSpec_1" class="form-control" name="spec_id_1">
                                          <option value selected>-- Please Select a Specification --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                  foreach ($spec_all as $spec) {
                                                      $specname = $spec['tblSpecification_Name'];
                                                      $specid = $spec['tblSpecification_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                  }
                                             ?>
                                          </select>
                                       </div>
                                       
                                       <div class="col-md-4">
                                          <select placeholder="" id="Add_slctProductSpec_2" class="form-control" name="spec_id_2">
                                             <option value selected>-- Please Select a Specification --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                  foreach ($spec_all as $spec) {
                                                      $specname = $spec['tblSpecification_Name'];
                                                      $specid = $spec['tblSpecification_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                  }
                                             ?>
                                          </select>
                                       </div>
                                       
                                       <div class="col-md-4">
                                          <select placeholder="" id="Add_slctProductSpec_3" class="form-control" name="spec_id_3">
                                             <option value selected>-- Please Select a Specification --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($spec_all as $spec) {
                                                      $specname = $spec['tblSpecification_Name'];
                                                      $specid = $spec['tblSpecification_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <input placeholder="Enter Specification 1 Value" id="Add_txtProductSpecV_1" class="form-control"  name="spec_val_1">
                                       </div>
                                       <div class="col-md-4">
                                          <input placeholder="Enter Specification 2 Value" id="Add_txtProductSpecV_2" class="form-control" name="spec_val_2">
                                       </div>
                                       <div class="col-md-4">
                                          <input placeholder="Enter Specification 3 Value" id="Add_txtProductSpecV_3" class="form-control" name="spec_val_3">
                                       </div>
                                    </div><br/>
                                    <div class="form-group" style="text-align:center;margin-top: 0px;">
                                       <div class="col-md-4">
                                          <label class="control-label">Select Product Specification 4</label>
                                       </div>
                                       <div class="col-md-4">
                                          <label class="control-label">Select Product Specification 5</label>
                                       </div>
                                       <div class="col-md-4">
                                          <label class="control-label">Select Product Specification 6</label>
                                       </div>
                                    </div><br/>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <select placeholder="" id="Add_slctProductSpec_4" class="form-control" name="spec_id_4">
                                             <option value selected>-- Please Select a Specification --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($spec_all as $spec) {
                                                      $specname = $spec['tblSpecification_Name'];
                                                      $specid = $spec['tblSpecification_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <select placeholder="" id="Add_slctProductSpec_5" class="form-control" name="spec_id_5">
                                             <option value selected>-- Please Select a Specification --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($spec_all as $spec) {
                                                      $specname = $spec['tblSpecification_Name'];
                                                      $specid = $spec['tblSpecification_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <select placeholder="" id="Add_slctProductSpec_6" class="form-control" name="spec_id_6">
                                             <option value selected>-- Please Select a Specification --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($spec_all as $spec) {
                                                      $specname = $spec['tblSpecification_Name'];
                                                      $specid = $spec['tblSpecification_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <input placeholder="Enter Specification 4 Value" id="Add_txtProductSpecV_4" class="form-control" name="spec_val_4">
                                       </div>
                                       <div class="col-md-4">
                                          <input placeholder="Enter Specification 5 Value" id="Add_txtProductSpecV_5" class="form-control" name="spec_val_5">
                                       </div>
                                       <div class="col-md-4">
                                          <input placeholder="Enter Specification 6 Value" id="Add_txtProductSpecV_6" class="form-control" name="spec_val_6">
                                       </div>
                                    </div>

                                    <h4 style="text-align:center; margin-top: 50px;">Product Images</h4><br/><br/>
                                    <div class="form-group" style="text-align:center;">
                                       <div class="col-md-3">
                                          <label class="control-label">Select Product Image 1</label>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="control-label">Select Product Image 2</label>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="control-label">Select Product Image 3</label>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="control-label">Select Product Image 4</label>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-3" style="display:flex;justify-content: center;">
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
                                       <div class="col-md-3" style="display:flex;justify-content: center;">
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
                                       <div class="col-md-3" style="display:flex;justify-content: center;">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div style="display:flex;justify-content: center; gap: 10px;">
                                                <span class="btn btn-theme02 btn-file" style="background-color: #48bcb4; border-color: #48bcb4;">
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" id="Add_fileProduct_3" class="default" name="image3"/>
                                                </span>
                                                <a href="" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-3" style="display:flex;justify-content: center;">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div style="display:flex;justify-content: center; gap: 10px;">
                                                <span class="btn btn-theme02 btn-file" style="background-color: #48bcb4; border-color: #48bcb4;">
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" id="Add_fileProduct_4" class="default" name="image4"/>
                                                </span>
                                                <a href="" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <hr style="height: 1px; border-width:0;color:#eff2f7;background-color:#eff2f7;">
                                 <div class="form-panel" style="box-shadow:none;">
                                    <h4 style="text-align:center;">Related Products</h4>
                                    <div class="form-group" style="text-align:center;">
                                       <div class="col-md-3">
                                          <label class="control-label">Related Product 1</label>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="control-label">Related Product 2</label>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="control-label">Related Product 3</label>
                                       </div>
                                       <div class="col-md-3">
                                          <label class="control-label">Related Product 4</label>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-3">
                                          <select placeholder="" id="Add_slctRelatedProduct_1" class="form-control" name="relatedProduct1">
                                             <option value selected>-- Please Select a Product --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($product_all as $spec) {
                                                      $specname = $spec['tblProduct_P_Name'];
                                                      $specid = $spec['tblProduct_P_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                       <div class="col-md-3">
                                          <select placeholder="" id="Add_slctRelatedProduct_2" class="form-control"  name="relatedProduct2">
                                             <option value selected>-- Please Select a Product --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($product_all as $spec) {
                                                      $specname = $spec['tblProduct_P_Name'];
                                                      $specid = $spec['tblProduct_P_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                       <div class="col-md-3">
                                          <select placeholder="" id="Add_slctRelatedProduct_3" class="form-control"  name="relatedProduct3">
                                             <option value selected>-- Please Select a Product --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($product_all as $spec) {
                                                      $specname = $spec['tblProduct_P_Name'];
                                                      $specid = $spec['tblProduct_P_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                       <div class="col-md-3">
                                          <select placeholder="" id="Add_slctRelatedProduct_4" class="form-control"  name="relatedProduct4">
                                             <option value selected>-- Please Select a Product --</option>
                                             <?php
                                                  // Display subjects as options in the select element
                                                   foreach ($product_all as $spec) {
                                                      $specname = $spec['tblProduct_P_Name'];
                                                      $specid = $spec['tblProduct_P_PK'];
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                    </div>
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
                                 <h4 style="text-align:center;">Edit / Delete Products</h4><br/>
                                    <div class="form-group" style="margin-left:20px">
                                       <label class="col-lg-2 control-label">Search Product :</label>
                                       <div class="col-lg-8">
                                          <input placeholder="Search by Name/SKU" id="Update_txtProductNameSKU" class="form-control">
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
                                             <th>SKU</th>
                                             <th>Name</th>
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
         $(document).ready(function () {
              $('#add_color').on('click', function () {
                  var selectedColor = $('#Add_slctProductColor option:selected').text();
                  var selectedId = $('#Add_slctProductColor option:selected').val();
                  console.log(selectedId)
                     if (selectedColor!="-- Please Select a Color Code --") {
                      // Check if the button for the selected color already exists
                      if ($('#wtc button[data-color="' + selectedId + '"]').length === 0) {
                          // Dynamically create a new button for the selected color
                          var colorName = $('#Add_slctProductColor option:selected').text();
                          $('#wtc').append('<button type="button" class="btn" style="'+"background:"+colorName+";width:80px;height:40px;border:1px solid white"+'" data-color="'+selectedId+'">' + '</button>');
                          updateSelectedColors();
                      }
                  } else {
                      alert('Please select a color.');
                  }
              });

              $('#clear').on('click', function () {
                  // Clear the selected color dropdown
                  $('#Add_slctProductColor').val('').trigger('change');
                  updateSelectedColors();
              });

              // Event delegation for dynamically generated buttons
              $('#wtc').on('click', 'button', function () {
                  // Remove the clicked color button
                  $(this).remove();
                  updateSelectedColors();
              });

              function updateSelectedColors() {
                  var selectedColors = [];
                  $('#wtc button').each(function () {
                      selectedColors.push($(this).data('color'));
                  });

                  // Update the hidden input field value
                  $('#selectedColors').val(selectedColors.join(','));
              }
         });

         $(document).ready(function () {
            $('#Update_btnSearch').click(function () {
               // Get the search query
               var searchQuery = $('#Update_txtProductNameSKU').val();
               
               // Perform an asynchronous search request using jQuery AJAX
               // Replace the placeholder URL with your actual server endpoint for searching
               $.ajax({
                  url: './controller/process_search.php',
                  type: 'GET',
                  data: { query: searchQuery },
                  success: function (data) {
                     // Display search results in the searchResults div
                     displaySearchResults(JSON.parse(data));
                  },
                  error: function (error) {
                     console.error('Error:', error);
                  }
               });
            });

            $('#Update_btnProduct').click(function () {
               // Get the data to update
               var updateData = gatherUpdateData();

               // Perform an asynchronous update request using jQuery AJAX
               // Replace the placeholder URL with your actual server endpoint for updating
               $.ajax({
                  url: '/update-endpoint',
                  type: 'POST',
                  contentType: 'application/json',
                  data: JSON.stringify(updateData),
                  success: function (data) {
                     // Display success message
                     $('#Del_lblProduct').show();
                  },
                  error: function (error) {
                     console.error('Error:', error);
                  }
               });
            });

             function displaySearchResults(results) {
               var searchResultsTableBody = $('#searchResults').find('tbody');
               // Clear previous search results
               searchResultsTableBody.empty();
               // Loop through the results and append rows to the table
               $.each(results, function (index, result) {
                  if(result.id){
                     var resultRow = $('<tr>');
                     resultRow.append($('<td>').text(result.id));
                     resultRow.append($('<td>').text(result.sku));

                     resultRow.append($('<td>').text(result.name)); // Replace with the actual property you want to display
                     // Actions column with Edit and Delete buttons
                     var actionsCell = $('<td>');
                     actionsCell.append('<button class="btn btn-info btn-sm btn-edit" data-id="' + result.id + '">Edit</button>');
                     actionsCell.append('<button style="margin-left:10px" class="btn btn-danger btn-sm btn-delete" data-id="' + result.id + '">Delete</button>');
                     resultRow.append(actionsCell);
                     // Add more columns as needed
                     searchResultsTableBody.append(resultRow);

                  }
               });

               // Attach event listeners to Edit and Delete buttons
               $('.btn-edit').click(function () {
                  var productId = $(this).data('id');
                  window.location.href = 'product_edit.php?id=' + productId;
               });

               $('.btn-delete').click(function () {
                  var productId = $(this).data('id');
                  if(confirm("Are you sure you want to delete this product?")){
                     window.location.href = 'controller/process_delete.php?id=' + productId;

                  }
                  
                  // Implement logic to delete the product
                  // Show confirmation modal or directly delete, etc.
                  console.log('Delete product with ID:', productId);
               });
            }

            function gatherUpdateData() {
               // Implement this function to gather data from the form
               // Return the data as an object
               return {
                  // Example: sku: $('#Update_txtProductSKU').val(),
                  // Replace with actual form fields
               };
            }
         });

      </script> 
   </body>
</html>