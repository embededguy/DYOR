<?php
session_start();
include('config/db.php');
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}
$id = isset($_GET['id']) ? $_GET['id'] : 0;

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

if($id!=0){
   $sql0 = "SELECT * FROM tblproduct_p WHERE tblProduct_P_PK = '$id'";
   $result0 = $conn->query($sql0);

   if ($result0->num_rows > 0) {
       $product = $result0->fetch_assoc();
   }else{
       $product = [];
   }

   $sql = "SELECT c.tblColor_ColorName,c.tblColor_PK
           FROM tblcolor_r_product crp
           INNER JOIN tblcolor_m c ON crp.tblColor_R_Product_ColorFK = c.tblColor_PK
           WHERE crp.tblColor_R_Product_ProductFK = $id";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       $color = $result->fetch_all(MYSQLI_ASSOC);
   }else{
       $color = [];
   }

   $sql = "SELECT s.tblSpecification_PK,s.tblSpecification_Name, srp.tblSpecification_R_Product_SpecificationValue
        FROM tblspecification_r_product srp
        INNER JOIN tblspecification_m s ON srp.tblSpecification_R_Product_SpecificationFK = s.tblSpecification_PK
        WHERE srp.tblSpecification_R_Product_ProductFK = $id";

   $result = $conn->query($sql);
   
   if ($result->num_rows > 0) {
       $specx = $result->fetch_all(MYSQLI_ASSOC);
   }else{
       $specx = [];
   }
   
   $sql = "SELECT tblImages_R_Product_ImageURL
        FROM tblimages_r_product
        WHERE tblImages_R_Product_ProductFK = $id";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       $imgx = $result->fetch_all(MYSQLI_ASSOC);
   }else{
       $imgx = [];
   }

   $sql_related_products = "
         SELECT p.tblProduct_P_PK, p.tblProduct_P_Name 
         FROM tblrelated_r_product trp
         INNER JOIN tblproduct_p p ON trp.tblRelated_R_Product_RProductFK  = p.tblProduct_P_PK
         WHERE trp.tblRelated_R_Product_PProductFK = $id 
         ";

   $result_related_products = $conn->query($sql_related_products);
   $rproducts = $result_related_products->fetch_all(MYSQLI_ASSOC);
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
    <script>
      function removeIMX(i){
         document.getElementById(`exi${i}`).src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"

         var path = document.getElementById(`e_image${i}`).value
         var formData = new FormData();
         formData.append('filename', path); // 'pdf' is the key name to access the file in PHP

         var xhr = new XMLHttpRequest();
         xhr.open('POST', './controller/process_remove_img.php', true); // Specify the PHP file to handle the upload
         xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Image Removed');
            } else {
                console.error('Error');
            }
         };
         xhr.send(formData);
      }
    </script>
   </head>
   <body>
      <section id="container">
         <?php include 'header.php';?>
         <?php include 'sidebar.php';?>
         <section id="main-content">
            <section class="wrapper">
               <div class="col-lg-12 mt">
               <h3><i class="fa fa-angle-right"></i> Product Edit</h3><br/>
               <div class="row content-panel">
                  <!-- /panel-heading -->
                  <div class="panel-body">
                     <div class="tab-content">
                        <div id="add" class="tab-pane active">
                           <div class="row">
                              <div class="form-panel" style="box-shadow:none;">
                                 <h4 style="text-align:center;">Edit Product Details</h4><br/>

                                 <form enctype="multipart/form-data" role="form" class="form-horizontal" action="controller/process_update_product.php" method="POST">
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Enter Product SKU :</label>
                                       <div class="col-lg-10">
                                          <input type="hidden" name="id" value="<?php echo $id;?>">
                                          <input value="<?php echo $product["tblProduct_P_SKU"];?>" name="sku" placeholder="Max 8 Characters!" id="Add_txtProductSKU" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Enter Product Name :</label>
                                       <div class="col-lg-10">
                                          <input value="<?php echo $product["tblProduct_P_Name"];?>" name="pname" placeholder="Max 60 Characters!" id="Add_txtProductName" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Product Category :</label>
                                       <div class="col-lg-10">
                                          <select name="category" placeholder="" id="Add_slctProductCategory" class="form-control">
                                             <option value="0">-- Select Category --</option>
                                             <option value="1" <?php echo ($product['tblProduct_P_Category'] == 1) ? 'selected' : ''; ?>>Ho.Re.Ca.</option>
                                             <option value="2" <?php echo ($product['tblProduct_P_Category'] == 2) ? 'selected' : ''; ?>>Medical</option>
                                             <option value="3" <?php echo ($product['tblProduct_P_Category'] == 3) ? 'selected' : ''; ?>>Salon & Spa</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Short Description :</label>
                                       <div class="col-lg-10">
                                          <input value="<?php echo $product['tblProduct_P_ShortDescription']; ?>" name="shortdesc" placeholder="Max 160 Characters!" id="Add_txtProductShortDesc" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Long Description :</label>
                                       <div class="col-lg-10">
                                          <textarea style="resize: vertical;" name="longdesc" placeholder="MarkUp Text!" id="Add_txtProductLongDesc" rows="5" class="form-control"><?php echo $product['tblProduct_P_LongDescription']; ?></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-lg-2 control-label">Meta KeyWords :</label>
                                       <div class="col-lg-10">
                                          <input name="keywords" value="<?php echo $product['tblProduct_P_MetaKeyWords']; ?>" placeholder="eg '#keyword1 #keyword2'" id="Add_txtProductKeywords" class="form-control">
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
                                       <?php
                                            // Display subjects as options in the select element
                                          foreach ($color as $spec) {
                                             $specname = $spec['tblColor_ColorName'];
                                             $specid = $spec['tblColor_PK'];
                                             echo '<button type="button" class="btn" style="'."background:".$specname.";width:80px;height:40px;border:1px solid white".'" data-color="'.$specid.'">'.'</button>';
                                          }
                                       ?>
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
                                                      $selected = $specid == $specx[0]['tblSpecification_PK']?'selected':'';
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
                                                      $selected = $specid == $specx[1]['tblSpecification_PK']?'selected':'';
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
                                                      $selected = $specid == $specx[2]['tblSpecification_PK']?'selected':'';
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <input value="<?php echo $specx[0]['tblSpecification_R_Product_SpecificationValue']; ?>" placeholder="Enter Specification 1 Value" id="Add_txtProductSpecV_1" class="form-control" name="spec_val_1">
                                       </div>
                                       <div class="col-md-4">
                                          <input value="<?php echo $specx[1]['tblSpecification_R_Product_SpecificationValue']; ?>" placeholder="Enter Specification 2 Value" id="Add_txtProductSpecV_2" class="form-control" name="spec_val_2">
                                       </div>
                                       <div class="col-md-4">
                                          <input value="<?php echo $specx[2]['tblSpecification_R_Product_SpecificationValue']; ?>"  placeholder="Enter Specification 3 Value" id="Add_txtProductSpecV_3" class="form-control" name="spec_val_3">
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
                                                      $selected = $specid == $specx[3]['tblSpecification_PK']?'selected':'';
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
                                                      $selected = $specid == $specx[4]['tblSpecification_PK']?'selected':'';
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
                                                      $selected = $specid == $specx[5]['tblSpecification_PK']?'selected':'';
                                                      echo "<option value='$specid' $selected>$specname</option>";
                                                   }
                                              ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <input value="<?php echo $specx[3]['tblSpecification_R_Product_SpecificationValue']; ?>" placeholder="Enter Specification 4 Value" id="Add_txtProductSpecV_4" class="form-control" name="spec_val_4">
                                       </div>
                                       <div class="col-md-4">
                                          <input value="<?php echo $specx[4]['tblSpecification_R_Product_SpecificationValue']; ?>" placeholder="Enter Specification 5 Value" id="Add_txtProductSpecV_5" class="form-control" name="spec_val_5">
                                       </div>
                                       <div class="col-md-4">
                                          <input value="<?php echo $specx[5]['tblSpecification_R_Product_SpecificationValue']; ?>" placeholder="Enter Specification 6 Value" id="Add_txtProductSpecV_6" class="form-control" name="spec_val_6">
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
                                       <?php
                                          for ($i=0; $i < 4 ; $i++) { 
                                             $src = $imgx[$i]['tblImages_R_Product_ImageURL'] ? $imgx[$i]['tblImages_R_Product_ImageURL']:'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';

                                             ?>
                                             <div class="col-md-3" style="display:flex;justify-content: center;">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                   <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                      <img src="<?php echo $src;?>" alt="" id="exi<?php echo $i+1;?>"/>
                                                   </div>
                                                   <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                   <div style="display:flex;justify-content: center; gap: 10px;">
                                                      <span class="btn btn-theme02 btn-file" style="background-color: #48bcb4; border-color: #48bcb4;">
                                                      <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                      <input type="hidden" id="e_image<?php echo $i+1;?>" name="e_image<?php echo $i+1;?>" value="<?php echo $imgx[$i]['tblImages_R_Product_ImageURL'];?>"/>
                                                      <input type="file" id="Add_fileProduct_1" class="default" name="image<?php echo $i+1;?>"/>
                                                      </span>
                                                      <?php if ($src != 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image'): ?>
                                                         <a class="btn btn-theme04" onclick="removeIMX(<?php echo $i+1;?>)"><i class="fa fa-trash-o"></i>Remove</a>
                                                      <?php endif ?>
                                                      <a href="" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i>Remove</a>
                                                   </div>
                                                </div>
                                             </div>
                                       <?php
                                          }
                                       ?>
                                    </div>
                                 </div>
                                 <hr style="height: 1px; border-width:0;color:#eff2f7;background-color:#eff2f7;">
                                 <div class="form-panel" style="box-shadow:none;">
                                     <h4 style="text-align:center;">Related Products</h4>
                                     <div class="form-group" style="text-align:center;">
                                         <?php for ($i = 1; $i <= 4; $i++) : ?>
                                             <div class="col-md-3">
                                                 <label class="control-label">Related Product <?php echo $i; ?></label>
                                             </div>
                                         <?php endfor; ?>
                                     </div>
                                     <div class="form-group">
                                         <?php for ($i = 1; $i <= 4; $i++) : ?>
                                             <div class="col-md-3">
                                                 <select placeholder="" class="form-control" id="Add_slctRelatedProduct_<?php echo $i; ?>" name="relatedProduct<?php echo $i; ?>">
                                                     <option value selected>-- Please Select a Product --</option>
                                                     <?php foreach ($product_all as $spec) : ?>
                                                         <?php
                                                         $specname = $spec['tblProduct_P_Name'];
                                                         $specid = $spec['tblProduct_P_PK'];
                                                         $selected = $spec['tblProduct_P_PK'] === $rproducts[$i-1]["tblProduct_P_PK"]? 'selected':'';
                                                         ?>
                                                         <option value='<?php echo $specid; ?>' <?php echo $selected; ?>><?php echo $specname; ?></option>
                                                     <?php endforeach; ?>
                                                 </select>
                                             </div>
                                         <?php endfor; ?>
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
              updateSelectedColors()
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