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

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/extension.css" />

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

						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>
						
										<h2 class="panel-title">Sources</h2>
									</header>
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
							</div>
						</div>

						<!-- end: page -->

					</section>
				<?php } ?>

				<?php function source() { ?>
					<?php $source['name'] = get('source'); ?>
					<section role="main" class="content-body">
						<header class="page-header">
							<h2>Capture Source > <?php echo $source['name']; ?></h2>

							<div class="right-wrapper pull-right">
								<ol class="breadcrumbs">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
										</a>
									</li>
									<li>
										<a href="dashboard.php?c=sources">
											<span>Sources</span>
										</a>
									</li>
									<li>
										<a href="dashboard.php?c=source&source=<?php echo $source['name']; ?>">
											<span><?php echo $source['name']; ?></span>
										</a>
									</li>
								</ol>
						
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>

						<!-- start: page -->

						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>
						
										<h2 class="panel-title">Form Elements</h2>
									</header>
									<div class="panel-body">
										<form class="form-horizontal form-bordered" method="get">
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Default</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="inputDefault">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDisabled">Disabled</label>
												<div class="col-md-6">
													<input class="form-control" id="inputDisabled" type="text" placeholder="Disabled input here..." disabled="">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputReadOnly">Read-Only Input</label>
												<div class="col-md-6">
													<input type="text" value="Read-Only Input" id="inputReadOnly" class="form-control" readonly="readonly">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputHelpText">Help text</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="inputHelpText">
													<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputRounded">Rounded Input</label>
												<div class="col-md-6">
													<input type="text" class="form-control input-rounded" id="inputRounded">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputFocus">Input focus</label>
												<div class="col-md-6">
													<input class="form-control" id="inputFocus" type="text" value="This is focused...">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputPlaceholder">Placeholder</label>
												<div class="col-md-6">
													<input type="text" class="form-control" placeholder="placeholder" id="inputPlaceholder">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputPassword">Password</label>
												<div class="col-md-6">
													<input type="password" class="form-control" placeholder="" id="inputPassword">
												</div>
											</div>
						
											<div class="form-group">
												<label class=" col-md-3 control-label">Static control</label>
												<div class="col-lg-6">
													<p class="form-control-static">email@example.com</p>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Left Icon</label>
												<div class="col-md-6">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-user"></i></span>
														</span>
														<input type="text" class="form-control" placeholder="Left icon">
													</div>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Right Icon</label>
												<div class="col-md-6">
													<div class="input-group input-group-icon">
														<input type="text" class="form-control" placeholder="Right icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-user"></i></span>
														</span>
													</div>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Search</label>
												<div class="col-md-6">
													<div class="input-group input-search">
														<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
														<span class="input-group-btn">
															<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
														</span>
													</div>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">File Upload</label>
												<div class="col-md-6">
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="fa fa-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-default btn-file">
																<span class="fileupload-exists">Change</span>
																<span class="fileupload-new">Select file</span>
																<input type="file" />
															</span>
															<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Vertical Group</label>
												<div class="col-md-6">
													<section class="form-group-vertical">
														<input class="form-control" type="text" placeholder="Username">
														<input class="form-control" type="text" placeholder="Email">
														<input class="form-control last" type="password" placeholder="Password">
													</section>
												</div>
											</div>
						
											<div class="form-group">
												<label class="control-label col-md-3">Vertical Group w/ icon</label>
												<div class="col-md-6">
													<section class="form-group-vertical">
														<div class="input-group input-group-icon">
															<span class="input-group-addon">
																<span class="icon"><i class="fa fa-user"></i></span>
															</span>
															<input class="form-control" type="text" placeholder="Username">
														</div>
														<div class="input-group input-group-icon">
															<span class="input-group-addon">
																<span class="icon"><i class="fa fa-key"></i></span>
															</span>
															<input class="form-control" type="text" placeholder="Password">
														</div>
													</section>
												</div>
											</div>
						
											<div class="form-group has-success">
												<label class="col-md-3 control-label" for="inputSuccess">Input with success</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="inputSuccess">
												</div>
											</div>
											<div class="form-group has-warning">
												<label class="col-md-3 control-label" for="inputWarning">Input with warning</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="inputWarning">
												</div>
											</div>
											<div class="form-group has-error">
												<label class="col-md-3 control-label" for="inputError">Input with error</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="inputError">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputTooltip">Input with Tooltip</label>
												<div class="col-md-6">
													<input type="text" placeholder="Hover me" title="" data-toggle="tooltip" data-trigger="hover" class="form-control" data-original-title="Place your tooltip info here" id="inputTooltip">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputPopover">Input with Popover</label>
												<div class="col-md-6">
													<input type="text" placeholder="Click Here" class="form-control" data-toggle="popover" data-placement="top" data-original-title="The Title" data-content="Content goes here..." data-trigger="click" id="inputPopover">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Column sizing</label>
												<div class="col-sm-8">
													<div class="row">
														<div class="col-sm-2">
															<input type="text" class="form-control" placeholder=".col-sm-2">
														</div>
														<div class="visible-xs mb-md"></div>
														<div class="col-sm-3">
															<input type="text" class="form-control" placeholder=".col-sm-3">
														</div>
														<div class="visible-xs mb-md"></div>
														<div class="col-sm-4">
															<input type="text" class="form-control" placeholder=".col-sm-4">
														</div>
													</div>
						
												</div>
											</div>
										</form>
									</div>
								</section>
						
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>
						
										<h2 class="panel-title">Controls sizing</h2>
									</header>
									<div class="panel-body">
										<form class="form-horizontal form-bordered" method="get">
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Input sizing</label>
												<div class="col-md-6">
													<input class="form-control input-lg mb-md" type="text" placeholder=".input-lg">
													<input class="form-control mb-md" type="text" placeholder="Default input">
													<input class="form-control input-sm mb-md" type="text" placeholder=".input-sm">
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Select sizing</label>
												<div class="col-md-6">
													<select class="form-control input-lg mb-md">
														<option>Option 1</option>
														<option>Option 2</option>
														<option>Option 3</option>
													</select>
													<select class="form-control mb-md">
														<option>Option 1</option>
														<option>Option 2</option>
														<option>Option 3</option>
													</select>
													<select class="form-control input-sm mb-md">
														<option>Option 1</option>
														<option>Option 2</option>
														<option>Option 3</option>
													</select>
												</div>
											</div>
										</form>
									</div>
								</section>
								<section class="panel">
									<div class="panel-body">
										<form class="form-horizontal form-bordered" method="get">
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Checkboxes and radios</label>
												<div class="col-md-6">
													<div class="checkbox">
														<label>
															<input type="checkbox" value="">
															Option one is this and that—be sure to include why it's great
														</label>
													</div>
						
													<div class="checkbox">
														<label>
															<input type="checkbox" value="">
															Option one is this and that—be sure to include why it's great option one
														</label>
													</div>
						
													<div class="radio">
														<label>
															<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
															Option one is this and that—be sure to include why it's great
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
															Option two can be something else and selecting it will deselect option one
														</label>
													</div>
						
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Inline checkboxes</label>
												<div class="col-md-6">
													<label class="checkbox-inline">
														<input type="checkbox" id="inlineCheckbox1" value="option1"> 1
													</label>
													<label class="checkbox-inline">
														<input type="checkbox" id="inlineCheckbox2" value="option2"> 2
													</label>
													<label class="checkbox-inline">
														<input type="checkbox" id="inlineCheckbox3" value="option3"> 3
													</label>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Selects</label>
												<div class="col-md-6">
													<select class="form-control mb-md">
														<option>1</option>
														<option>2</option>
														<option>3</option>
														<option>4</option>
														<option>5</option>
													</select>
						
													<select multiple="" class="form-control">
														<option>1</option>
														<option>2</option>
														<option>3</option>
														<option>4</option>
														<option>5</option>
													</select>
												</div>
											</div>
						
										</form>
									</div>
								</section>
						
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>
						
										<h2 class="panel-title">Input Groups</h2>
									</header>
									<div class="panel-body">
										<form class="form-horizontal form-bordered" method="get">
											<div class="form-group">
												<label class="col-md-3 control-label">Basic examples</label>
												<div class="col-md-6">
													<div class="input-group mb-md">
														<span class="input-group-addon btn-success">@</span>
														<input type="text" class="form-control" placeholder="Username">
													</div>
						
													<div class="input-group mb-md">
														<input type="text" class="form-control">
														<span class="input-group-addon btn-warning">.00</span>
													</div>
						
													<div class="input-group mb-md">
														<span class="input-group-addon">$</span>
														<input type="text" class="form-control">
														<span class="input-group-addon ">.00</span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Sizing</label>
												<div class="col-md-6">
													<div class="input-group input-group-lg mb-md">
														<span class="input-group-addon btn-danger">@</span>
														<input type="text" class="form-control input-lg" placeholder="Username">
													</div>
						
													<div class="input-group mb-md">
														<span class="input-group-addon">@</span>
														<input type="text" class="form-control" placeholder="Username">
													</div>
						
													<div class="input-group input-group-sm mb-md">
														<span class="input-group-addon">@</span>
														<input type="text" class="form-control" placeholder="Username">
													</div>
						
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Iconic</label>
												<div class="col-md-6">
													<div class="input-group mb-md">
														<span class="input-group-addon">
															<i class="fa fa-user"></i>
														</span>
														<input type="text" class="form-control" placeholder="Username">
													</div>
													<div class="input-group mb-md">
														<span class="input-group-addon">
															<i class="fa fa-envelope"></i>
														</span>
														<input type="text" class="form-control" placeholder="Email">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Checkbox and radio</label>
												<div class="col-md-6">
													<div class="input-group mb-md">
														<span class="input-group-addon">
															<input type="checkbox">
														</span>
														<input type="text" class="form-control">
													</div>
						
													<div class="input-group mb-md">
														<span class="input-group-addon">
															<input type="radio">
														</span>
														<input type="text" class="form-control">
													</div>
						
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Button addons</label>
												<div class="col-md-6">
													<div class="input-group mb-md">
														<span class="input-group-btn">
															<button class="btn btn-danger" type="button">Go!</button>
														</span>
														<input type="text" class="form-control">
													</div>
						
													<div class="input-group mb-md">
														<input type="text" class="form-control">
														<span class="input-group-btn">
															<button class="btn btn-success" type="button">Go!</button>
														</span>
													</div>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Segmented buttons</label>
												<div class="col-md-6">
													<div class="input-group mb-md">
														<div class="input-group-btn">
															<button tabindex="-1" class="btn btn-primary" type="button">Action</button>
															<button tabindex="-1" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
																<span class="caret"></span>
															</button>
															<ul role="menu" class="dropdown-menu">
																<li><a href="#">Action</a></li>
																<li><a href="#">Another action</a></li>
																<li><a href="#">Something else here</a></li>
																<li class="divider"></li>
																<li><a href="#">Separated link</a></li>
															</ul>
														</div>
														<input type="text" class="form-control">
													</div>
						
													<div class="input-group mb-md">
														<input type="text" class="form-control">
														<div class="input-group-btn">
															<button tabindex="-1" class="btn btn-primary" type="button">Action</button>
															<button tabindex="-1" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
																<span class="caret"></span>
															</button>
															<ul role="menu" class="dropdown-menu pull-right">
																<li><a href="#">Action</a></li>
																<li><a href="#">Another action</a></li>
																<li><a href="#">Something else here</a></li>
																<li class="divider"></li>
																<li><a href="#">Separated link</a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
						
										</form>
									</div>
								</section>
						
							</div>
						</div>

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
				// show_source_list();
			}, 5000);

			function update_system_stats() {
				console.log('updating system stats.');
				$.ajax({
			        url:'actions.php?a=get_system_stats',
			        type: 'json',
			        success: function(content,code) {
			        	var data = jQuery.parseJSON(content);
			            
						console.log(data.ip_address);

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

			<?php if($_GET['c'] == 'sources') { ?>
				window.setInterval(function() {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=ajax_source_list',
						success: function(sources) {
							// var x = sources[0].source.name;
							// console.log('Source Name: ' + x);

							for (i in sources)
							{
								// colum 1
								if(sources[i].source.status == 'busy') {
									document.getElementById(sources[i].source.name + '_col_1').innerHTML = '<span class="label label-success">Streaming</span>';
								} else {
									document.getElementById(sources[i].source.name + '_col_1').innerHTML = '<span class="label label-danger">Not Streaming</span>';
								}

								// colum 2
								document.getElementById(sources[i].source.name + '_col_2').innerHTML = sources[i].source.name;

								// colum 3
								document.getElementById(sources[i].source.name + '_col_3').innerHTML = sources[i].source.command;

								// colum 4
								if(sources[i].source.status == 'busy') {
									document.getElementById(sources[i].source.name + '_col_4').innerHTML = '<a title="Stop Streaming" class="btn btn-danger btn-flat" href="actions.php?a=source_stop&pid=' + sources[i].source.pid + '"><i class="fa fa-times"></i></a> <a title="Edit" class="btn btn-primary btn-flat" href="dashboard.php?c=source&source=' + sources[i].source.name + '"><i class="fa fa-globe"></i></a>';
								} else {
									document.getElementById(sources[i].source.name + '_col_4').innerHTML = '<a title="Start Streaming" class="btn btn-success btn-flat" href="actions.php?a=source_start&source=' + sources[i].source.name + '"><i class="fa fa-check"></i></a> <a title="Edit" class="btn btn-primary btn-flat" href="dashboard.php?c=source&source=' + sources[i].source.name + '"><i class="fa fa-globe"></i></a>';
								}
							}						
						}
					});
				}, 2000);
			<?php } ?>
		</script>
	</body>
</html>