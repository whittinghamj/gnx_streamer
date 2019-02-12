<?php
// start php session
session_start();

// includes
include('inc/global_vars.php');
include('inc/functions.php');

// read the config file
$config_raw 		= @file_get_contents('config.json');
$config 			= json_decode($config_raw, true);

if($_SESSION['logged_in'] != true) {
	go("not_logged_in.php");
}

?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

    	<title><?php echo $site['title']; ?></title>
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
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="" class="logo">
						<h3><?php echo $site['name_short']; ?></h3>
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/images/!logged-user.jpg" alt="<?php echo $_SESSION['username']; ?>" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="<?php echo $_SESSION['username']; ?>" data-lock-email="<?php echo $_SESSION['username']; ?>">
								<span class="name"><?php echo $_SESSION['username']; ?></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="index"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									<li>
										<a href="dashboard.php?c=sources">
											<i class="fa fa-bars" aria-hidden="true"></i>
											<span>Sources</span>
										</a>
									</li>
								</ul>
							</nav>
				
							<hr class="separator" />
				
							<div class="sidebar-widget widget-stats">
								<div class="widget-content">
									<ul>
										<li>
											<span class="stats-title">CPU</span>
											<span id="cpu_usage_display" class="stats-complete">0%</span>
											<div class="progress">
												<div id="cpu_usage_bar" class="progress-bar progress-bar-success progress-without-number" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">RAM</span>
											<span id="ram_usage_display" class="stats-complete">0%</span>
											<div class="progress">
												<div id="ram_usage_bar" class="progress-bar progress-bar-success progress-without-number" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">HDD</span>
											<span id="disk_usage_display" class="stats-complete">0%</span>
											<div class="progress">
												<div id="disk_usage_bar" class="progress-bar progress-bar-success progress-without-number" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</aside>
				<!-- end: sidebar -->

				<?php
					$c = $_GET['c'];
					switch ($c){
						// test
						case "test":
							test();
							break;

		                // sources
		                case "sources":
		                    sources();
		                    break;

		                // source
		                case "source":
		                    source();
		                    break;
							
						// home
						default:
							home();
							break;
					}
				?>

				<?php function home() { ?>
					<section role="main" class="content-body">
						<header class="page-header">
							<h2>Dashboard</h2>

							<div class="right-wrapper pull-right">
								<ol class="breadcrumbs">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
										</a>
									</li>
									<!--
									<li><span>Layouts</span></li>
									<li><span>Boxed</span></li>
									-->
								</ol>
						
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>

						<!-- start: page -->

						<section class="panel">
							<div class="panel-body">
								dashboard home content
							</div>
						</section>

						<!-- end: page -->

					</section>
				<?php } ?>

				<?php function sources() { ?>
					<section role="main" class="content-body">
						<header class="page-header">
							<h2>Capture Sources</h2>

							<div class="right-wrapper pull-right">
								<ol class="breadcrumbs">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
										</a>
									</li>
									<li><span>Sources</span></li>
									<!--
									<li><span>Boxed</span></li>
									-->
								</ol>
						
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>

						<!-- start: page -->

						<section class="panel">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped mb-none">
										<thead>
											<tr>
												<th width="10px">#</th>
												<th width="100px">Status</th>
												<th width="50px">Device</th>
												<th>Process</th>
												<th width="200px">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php show_installed_devices(); ?>
										</tbody>
									</table>
								</div>
							</div>
						</section>

						<!-- end: page -->

					</section>
				<?php } ?>

			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Recent Events</h6>
								<!-- <div data-plugin-datepicker data-plugin-skin="dark" ></div> -->
			
								<ul>
									<li>
										<time>11/02/2019 00:10:09</time>
										<span>System Rebooting</span>
									</li>
								</ul>
							</div>
			
							<!--
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
							-->
						</div>
					</div>
				</div>
			</aside>

			<!-- Vendor -->
			<script src="assets/vendor/jquery/jquery.js"></script>
			<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
			<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
			<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
			<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
			<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
			<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
			
			<!-- Specific Page Vendor -->
			
			<!-- Theme Base, Components and Settings -->
			<script src="assets/javascripts/theme.js"></script>
			
			<!-- Theme Custom -->
			<script src="assets/javascripts/theme.custom.js"></script>
			
			<!-- Theme Initialization Files -->
			<script src="assets/javascripts/theme.init.js"></script>

		</section>

		<script>
			window.setInterval(function() {
				// update_system_stats();
				show_source_list();
			}, 5000);

			function update_system_stats() {
				console.log('updating system stats.');
				$.ajax({
			        url:'actions.php?a=get_system_stats',
			        type: 'json',
			        success: function(content,code) {
			        	var data = jQuery.parseJSON(content);
			            
						// console.log(data.ip_address);

						// cpu_usage
						$('#cpu_usage_display').html(data.cpu_usage + '%');
						$('#cpu_usage_bar').attr('aria-valuenow', data.cpu_usage).css('width', data.cpu_usage);
						if(data.cpu_usage > 80) {
							$('#cpu_usage_bar').removeClass("progress-bar-success");
							$('#cpu_usage_bar').addClass("progress-bar-danger");
						}

						// ram_usage
						$('#ram_usage_display').html(data.ram_usage + '%');
						$('#ram_usage_bar').attr('aria-valuenow', data.ram_usage).css('width', data.ram_usage);
						if(data.disk_usage > 80) {
							$('#ram_usage_bar').removeClass("progress-bar-success");
							$('#ram_usage_bar').addClass("progress-bar-danger");
						}

						// dis_usage
						$('#disk_usage_display').html(data.disk_usage + '%');
						$('#disk_usage_bar').attr('aria-valuenow', data.disk_usage).css('width', data.disk_usage);
						if(data.disk_usage > 80) {
							$('#disk_usage_bar').removeClass("progress-bar-success");
							$('#disk_usage_bar').addClass("progress-bar-danger");
						}
			        }
			    });
			}

			function show_source_list() {
				$.ajax({
					cache: false,
					type: "GET",
			        url:'http://localhost/actions.php?a=ajax_source_list',
					success: function(sources) {
						// var x = sources[0].source.name;
						// console.log('Source Name: ' + x);

						for (i in sources)
						{
							// colum 2
							document.getElementById(sources[i].source.name + '_col_2').innerHTML = 'test' + sources[i];
						}						
					}
				});
			}
		</script>
	</body>
</html>