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

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>DYOR - Specification Add / Edit / Delete</title>
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

	</head>
	<body>
		<section id="container">
			<?php include 'header.php';?>
			<?php include 'sidebar.php';?>
			<section id="main-content">
				<section class="wrapper">
					<div class="col-lg-12 mt">
						<h3><i class="fa fa-angle-right"></i> Specification</h3><br/>
						<div class="row content-panel">
							<div class="panel-heading">
								<ul class="nav nav-tabs nav-justified">
									<li class="active">
										<a data-toggle="tab" href="#add">ADD</a>
									</li>
									<li>
										<a data-toggle="tab" href="#update">Update</a>
									</li>
									<li>
										<a data-toggle="tab" href="#delete">Delete</a>
									</li>
								</ul>
							</div>
							<!-- /panel-heading -->
							<div class="panel-body">
								<div class="tab-content">
									<div id="add" class="tab-pane active">
										<h3 style="text-align:center;">Add Specification</h3>
										<div class="row">
											<div class="form-panel" style="box-shadow:none;">
												<form role="form" class="form-horizontal" action="controller/process_add_specification.php" method="POST">
													<div class="form-group has-success">
														<label class="col-lg-2 control-label" style="color:white">Enter Specification</label>
														<div class="col-lg-10">
															<input type="text" placeholder="Specification Name" id="Add_txtSpecification" name="specification_name" class="form-control">
															<?php
												                // Check if the success parameter is present in the query string
												                if (isset($_GET['specadded']) && $_GET['specadded'] == 1) {
												                    echo '<div class="success-message">Specification added successfully!</div>';
												                }
												            ?>
														</div>
														<div class="col-lg-8 col-lg-offset-2" style="margin-top:20px">
															<button class="col-lg-2 btn btn-theme" id="Add_btnSpecification" type="submit">Add</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div id="update" class="tab-pane">
										<h3 style="text-align:center;">Update Specification</h3>
										<div class="row">
											<div class="form-panel" style="box-shadow:none;">
												<form role="form" class="form-horizontal" action="controller/process_update_specification.php" method="POST">
													<div class="form-group">
														<label class="col-lg-2 control-label" style="color:white">Select Specification</label>
														<div class="col-lg-10">
															<select placeholder="" name="specid" id="Update_slctSpecification" class="form-control" required>
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
													<div class="form-group has-success">
														<label class="col-lg-2 control-label" style="color:white">Update Specification</label>
														<div class="col-lg-10">
															<input type="text" name="specvalue" placeholder="Updated Name of Specification" id="Update_txtSpecification" class="form-control">
															<?php
												                // Check if the success parameter is present in the query string
												                if (isset($_GET['specupdated']) && $_GET['specupdated'] == 1) {
												                    echo '<div class="success-message">Specification Updated Successfully!</div>';
												                }
												            ?>
														</div>

														<div class="col-lg-10 col-lg-offset-2"  style="margin-top:20px">
															<button class="col-lg-2 btn btn-theme" id="Update_btnSpecification" type="submit">Update</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div id="delete" class="tab-pane">
										<h3 style="text-align:center;">Delete Specification</h3>
										<div class="row">
											<div class="form-panel" style="box-shadow:none;">
												<form role="form" class="form-horizontal" action="controller/process_delete_specification.php" method="POST">
													<div class="form-group has-success">
														<label class="col-lg-2 control-label" style="color:white">Specification Name</label>
														<div class="col-lg-10">
															<select id="Delete_slctSpecification" class="form-control" name="specid" required>
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

															<?php
												                // Check if the success parameter is present in the query string
												                if (isset($_GET['specdeleted']) && $_GET['specdeleted'] == 1) {
												                    echo '<div class="success-message">Specification Deleted Successfully!</div>';
												                }
												            ?>
														</div>
														<div class="col-lg-10 col-lg-offset-2"  style="margin-top:20px">
															<button class="col-lg-2 btn btn-theme" id="Delete_btnSpecification" type="submit" >Delete</button>
														</div>
													</div>
												</form>
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