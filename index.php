<?php

echo 'test';

include('inc/global_vars.php');
include('inc/db.php');

// check if this is a new install
$query = "SELECT `id` FROM `users`";
$result = mysql_query($query) or die(mysql_error());
$records = mysql_num_rows($result);
if($records == 0){
	$action = 'install';
}else{
	$action = 'login';
}
?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>
            <?php echo $site['title']; ?>
        </title>

		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<h3><?php echo $site['name_short']; ?></h3>

				<?php if($action == 'login') { ?> 
					<div class="panel panel-sign">
						<div class="panel-title-sign mt-xl text-right">
							<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
						</div>
						<div class="panel-body">
							<form action="login.php" method="post">
								<div class="form-group mb-lg">
									<label>Username</label>
									<div class="input-group input-group-icon">
										<input name="username" type="text" class="form-control input-lg" />
										<span class="input-group-addon">
											<span class="icon icon-lg">
												<i class="fa fa-user"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group mb-lg">
									<!--
									<div class="clearfix">
										<label class="pull-left">Password</label>
										<a href="pages-recover-password.html" class="pull-right">Lost Password?</a>
									</div>
									-->
									<div class="input-group input-group-icon">
										<input name="password" type="password" class="form-control input-lg" />
										<span class="input-group-addon">
											<span class="icon icon-lg">
												<i class="fa fa-lock"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-8">
										<!--
										<div class="checkbox-custom checkbox-default">
											<input id="RememberMe" name="rememberme" type="checkbox"/>
											<label for="RememberMe">Remember Me</label>
										</div>
										-->
									</div>
									<div class="col-sm-4 text-right">
										<button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
										<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
									</div>
								</div>

								<!--
								<span class="mt-lg mb-lg line-thru text-center text-uppercase">
									<span>or</span>
								</span>

								<div class="mb-xs text-center">
									<a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
									<a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
								</div>

								<p class="text-center">Don't have an account yet? <a href="pages-signup.html">Sign Up!</a>
								-->
							</form>
						</div>
					</div>
				<?php }else{ ?>
					<div class="panel panel-sign">
						<div class="panel-title-sign mt-xl text-right">
							<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign Up</h2>
						</div>
						<div class="panel-body">
							<form>
								<div class="form-group mb-lg">
									<label>Name</label>
									<input name="name" type="text" class="form-control input-lg" />
								</div>

								<div class="form-group mb-lg">
									<label>E-mail Address</label>
									<input name="email" type="email" class="form-control input-lg" />
								</div>

								<div class="form-group mb-none">
									<div class="row">
										<div class="col-sm-6 mb-lg">
											<label>Password</label>
											<input name="pwd" type="password" class="form-control input-lg" />
										</div>
										<div class="col-sm-6 mb-lg">
											<label>Password Confirmation</label>
											<input name="pwd_confirm" type="password" class="form-control input-lg" />
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-8">
										<div class="checkbox-custom checkbox-default">
											<input id="AgreeTerms" name="agreeterms" type="checkbox"/>
											<label for="AgreeTerms">I agree with <a href="#">terms of use</a></label>
										</div>
									</div>
									<div class="col-sm-4 text-right">
										<button type="submit" class="btn btn-primary hidden-xs">Sign Up</button>
										<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign Up</button>
									</div>
								</div>

								<span class="mt-lg mb-lg line-thru text-center text-uppercase">
									<span>or</span>
								</span>

								<div class="mb-xs text-center">
									<a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
									<a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
								</div>

								<p class="text-center">Already have an account? <a href="pages-signin.html">Sign In!</a>

							</form>
						</div>
					</div>
				<?php } ?>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y"); ?>. All rights reserved. Written by <a href="https://genexnetworks.net">Genex Networks</a>.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>