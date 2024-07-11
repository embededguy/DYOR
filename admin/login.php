<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>DYOR - Login</title>
		<!-- Favicons -->
		<link href="img/favicon.png" rel="icon">
		<link href="img/apple-touch-icon.png" rel="apple-touch-icon">
		<!-- Bootstrap core CSS -->
		<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!--external css-->
		<link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<!-- Custom styles for this template -->
		<link href="css/style.css" rel="stylesheet">
		<link href="css/style-responsive.css" rel="stylesheet">
	</head>
	<body>
		<div id="login-page">
			<div class="container">
				<form class="form-login" action="controller/process_login.php" method="POST">
					<h2 class="form-login-heading" style="font-weight: 500;">Login</h2>
					<div class="login-wrap">
						<input type="text" class="form-control" placeholder="Email Id" name="email" autofocus>
						<br>
						<input type="password" class="form-control" placeholder="Password" name="password">
						<br>
						<button class="btn btn-theme btn-block" href="index.html" type="submit" style="height: 40px;"><i class="fa fa-lock"></i> LOG IN</button>
					</div>
				</form>
			</div>
		</div>
		<!-- js placed at the end of the document so the pages load faster -->
		<script src="lib/jquery/jquery.min.js"></script>
		<script src="lib/bootstrap/js/bootstrap.min.js"></script>
		<!--BACKSTRETCH-->
		<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
	
	</body>
</html>