<?php
session_start();

// includes
include('inc/global_vars.php');
include('inc/functions.php');

// read the config file
if(!file_exists('config.json')){
	die('Missing config.json file.');
}else{
	$config_raw 		= @file_get_contents('config.json');
	$config 			= json_decode($config_raw);
}

if($_SESSION['logged_in'] != true) {
	go("/index.php");
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

		<link rel="stylesheet" href="assets/stylesheets/bootstrap-select.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/extension.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

		<!-- flowplayer skin -->
		<link rel="stylesheet" href="https://releases.flowplayer.org/7.2.7/skin/skin.css">
   
		<!-- hls.js -->
		<script src="https://cdn.jsdelivr.net/npm/hls.js@0.11.0/dist/hls.light.min.js"></script>

		<!-- flowplayer -->
		<script src="https://releases.flowplayer.org/7.2.7/flowplayer.min.js"></script>

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />

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
									<a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
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
									<li>
										<a href="dashboard.php?c=watermarks">
											<i class="fa fa-file-image-o" aria-hidden="true"></i>
											<span>Watermark Images</span>
										</a>
									</li>
									<?php if(file_exists('addons/roku/') && file_exists('addons/roku/index.php')) { ?>
										<li>
											<a href="dashboard.php?c=roku_remotes">
												<i class="fa fa-link" aria-hidden="true"></i>
												<span>ROKU Remotes</span>
											</a>
										</li>
									<?php } ?>
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

						// watermarks
		                case "watermarks":
		                    watermarks();
		                    break;

		                // roku_remotes
		                case "roku_remotes":
		                    roku_remotes();
		                    break;

		                // roku_remote
		                case "roku_remote":
		                    roku_remote();
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
								<a class="mb-xs mt-xs mr-xs modal-sizes btn btn-info" href="#modalBasic">View Stream</a>

								<div id="modalBasic" class="modal-block mfp-hide">
									<section class="panel">
										<header class="panel-heading">
											<h2 class="panel-title">Live Stream from video0</h2>
										</header>
										<div class="panel-body">
											<div class="modal-wrapper">
												<div class="modal-text">
													<div id="fp-hlsjs" style="width:100%;"></div>
													<script>
														flowplayer("#fp-hlsjs", {
															ratio: 9/16,
														   	clip: {
														      	autoplay: true,
														       	title: "video0 source",
														       	sources: [{ 
																	type: "application/x-mpegurl",
														            src:  "http://192.168.1.50:9000/hls/video0.m3u8",
														            live: true          
																}]
														   	},
														   	embed: false,
														   	share: false,
														});
													</script>
												</div>
											</div>
										</div>
										<footer class="panel-footer">
											<div class="row">
												<div class="col-md-12 text-right">
													<!-- <button class="btn btn-primary modal-confirm">Confirm</button> -->
													<button class="btn btn-info modal-dismiss">Close</button>
												</div>
											</div>
										</footer>
									</section>
								</div>
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
								</ol>
						
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>

						<!-- start: page -->
						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions"></div>
										<h2 class="panel-title">Sources</h2>
									</header>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped mb-none">
												<thead>
													<tr>
														<th width="10px">#</th>				<!-- 0 -->
														<th width="50px">Status</th>		<!-- 1 -->
														<th width="50px">Device</th>		<!-- 2 -->
														<th width="100px">V Codec</th>		<!-- 3 -->
														<th width="50px">Resolution</th>	<!-- 4 -->
														<th width="100px">A Codec</th>		<!-- 5 -->
														<th width="50px">Bitrate</th>		<!-- 6 -->
														<th>Stream Type</th>				<!-- 7 -->
														<th width="100px">Uptime</th>		<!-- 8 -->
														<th width="100px">Actions</th>		<!-- 9 -->
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
					<?php 
						if(!file_exists('config/'.$source['name'].'.json')){
							// missing config file, load template one
							$file_exists = 'file_not_found';
						}else{
							$file_exists = 'file_found';
							$source['config'] 		= @file_get_contents('config/'.$source['name'].'.json');
							$source['config'] 		= json_decode($source['config'], true);
						}

						$audio_devices 				= shell_exec('sudo arecord -L | grep "hw:CARD=D" | grep -v "plug"');
						$audio_devices 				= explode("\n", $audio_devices);
						$audio_devices 				= array_filter($audio_devices);
					?>

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
									<form action="actions.php?a=source_update" class="form-horizontal form-bordered" method="post">
										<input type="hidden" name="source" value="<?php echo $source['name']; ?>">
										<header class="panel-heading">
											<div class="panel-actions"></div>
											<h2 class="panel-title">Settings (<?php echo $file_exists; ?>)</h2>
										</header>
										<div class="panel-body">
											<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
												<pre>
													<?php print_r($source['config']); ?>
												</pre>
											<?php } ?>

											<div class="form-group">
												<label class="col-md-3 control-label" for="stream">Stream</label>
												<div class="col-md-6">
													<select id="stream" name="stream" class="form-control input-sm mb-md">
														<option <?php if($source['config']['stream']=='enable'){echo"selected";} ?> value="enable">Enable</option>
														<option <?php if($source['config']['stream']=='disable'){echo"selected";} ?> value="disable">Disable</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="name">Video Source Name</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="name" name="name" disabled value="<?php echo $source['name']; ?>">
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="framerate_in">Input Framerate</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="framerate_in" name="framerate_in" value="<?php echo $source['config']['framerate_in']; ?>" placeholder="29">
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="screen_resolution">Output Video Resolution</label>
												<div class="col-md-6">
													<select id="screen_resolution" name="screen_resolution" class="form-control input-sm mb-md">
														<option <?php if($source['config']['screen_resolution']=='1920x1080'){echo"selected";} ?> value="1920x1080">1920x1080</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1680x1056'){echo"selected";} ?> value="1680x1056">1680x1056</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1280x720'){echo"selected";} ?> value="1280x720">1280x720</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1024x576'){echo"selected";} ?> value="1024x576">1024x576</option>
					                                    <option <?php if($source['config']['screen_resolution']=='850x480'){echo"selected";} ?> value="850x480">850x480</option>
					                                    <option <?php if($source['config']['screen_resolution']=='720x576'){echo"selected";} ?> value="720x576">720x576</option>
					                                    <option <?php if($source['config']['screen_resolution']=='720x540'){echo"selected";} ?> value="720x540">720x540</option>
					                                    <option <?php if($source['config']['screen_resolution']=='720x480'){echo"selected";} ?> value="720x480">720x480</option>
					                                    <option <?php if($source['config']['screen_resolution']=='720x404'){echo"selected";} ?> value="720x404">720x404</option>
					                                    <option <?php if($source['config']['screen_resolution']=='704x576'){echo"selected";} ?> value="704x576">704x576</option>
					                                    <option <?php if($source['config']['screen_resolution']=='640x480'){echo"selected";} ?> value="640x480">640x480</option>
					                                    <option <?php if($source['config']['screen_resolution']=='640x360'){echo"selected";} ?> value="640x360">640x360</option>
					                                    <option <?php if($source['config']['screen_resolution']=='320x240'){echo"selected";} ?> value="320x240">320x240</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1600x1200'){echo"selected";} ?> value="1600x1200">1600x1200</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1280x960'){echo"selected";} ?> value="1280x960">1280x960</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1152x864'){echo"selected";} ?> value="1152x864">1152x864</option>
					                                    <option <?php if($source['config']['screen_resolution']=='1024x768'){echo"selected";} ?> value="1024x768">1024x768</option>
					                                    <option <?php if($source['config']['screen_resolution']=='800x600'){echo"selected";} ?> value="800x600">800x600</option>
					                                    <option <?php if($source['config']['screen_resolution']=='768x576'){echo"selected";} ?> value="768x576">768x576</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="video_codec">Output Video Codec</label>
												<div class="col-md-6">
													<select id="video_codec" name="video_codec" class="form-control input-sm mb-md">
														<option <?php if($source['config']['video_codec']=='libx264'){echo"selected";} ?> value="libx264">H.264</option>
														<option <?php if($source['config']['video_codec']=='libx265'){echo"selected";} ?> value="libx265">H.265</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="framerate_out">Output Video Framerate</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="framerate_out" name="framerate_out" value="<?php echo $source['config']['framerate_out']; ?>" placeholder="29">
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="audio_device">Audio Source Name</label>
												<div class="col-md-6">
													<select id="audio_device" name="audio_device" class="form-control input-sm mb-md">
														<?php foreach($audio_devices as $audio_device) { ?>
															<option <?php if($audio_device==$source['config']['audio_device']){echo"selected";} ?> value="<?php echo $audio_device; ?>"><?php echo $audio_device; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="audio_codec">Output Audio Codec</label>
												<div class="col-md-6">
													<select id="audio_codec" name="audio_codec" class="form-control input-sm mb-md">
														<option <?php if($source['config']['audio_codec']=='aac'){echo"selected";} ?> value="aac">AAC</option>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="audio_bitrate">Output Audio Bitrate (k)</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="audio_bitrate" name="audio_bitrate" value="<?php echo $source['config']['audio_bitrate']; ?>" placeholder="128">
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="audio_sample_rate">Output Audio Sample Rate</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="audio_sample_rate" name="audio_sample_rate" value="<?php echo $source['config']['audio_sample_rate']; ?>" placeholder="44100">
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="bitrate">Output Stream Bitrate (k)</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="bitrate" name="bitrate" value="<?php echo $source['config']['bitrate']; ?>" placeholder="3500">
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="output_type">Output Type</label>
												<div class="col-md-6">
													<select id="output_type" name="output_type" class="form-control input-sm mb-md">
														<option <?php if($source['config']['output_type']=='rtmp'){echo"selected";} ?> value="rtmp">RTMP Push</option>
														<option <?php if($source['config']['output_type']=='http'){echo"selected";} ?> value="http">HTTP Stream</option>
													</select>
												</div>
											</div>

											<div id="rtmp" class="form-group">
												<label class="col-md-3 control-label" for="rtmp_server">RTMP Server</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="rtmp_server" name="rtmp_server" value="<?php echo $source['config']['rtmp_server']; ?>" placeholder="rtmp://server.com/channel/key">
												</div>
											</div>

											<div id="http" class="form-group">
												<label class="col-md-3 control-label" for="http_server">HTTP Server</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="http_server" name="http_server" value="http://<?php echo $_SERVER['SERVER_ADDR']; ?>:9000/hls/<?php echo $source['name']; ?>.m3u8" readonly>
													<!-- <input type="text" class="form-control" id="http_server_hd" name="http_server_hd" value="http://<?php echo $_SERVER['SERVER_ADDR']; ?>:9000/hls/<?php echo $source['name']; ?>_hd.m3u8" readonly> -->
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="watermark_type">Watermark</label>
												<div class="col-md-6">
													<select id="watermark_type" name="watermark_type" class="form-control input-sm mb-md">
														<option <?php if($source['config']['watermark_type']=='disable'){echo"selected";} ?> value="disable">Disable</option>
														<option <?php if($source['config']['watermark_type']=='image'){echo"selected";} ?> value="image">Image</option>
														<!-- <option <?php if($source['config']['watermark_type']=='disable'){echo"selected";} ?> value="disable">Disable</option> -->
													</select>
												</div>
											</div>

											<?php if($source['config']['watermark_type'] == 'image') { ?>
												<div class="form-group">
													<label class="col-md-3 control-label" for="watermark_image">Watermark Image</label>
													<div class="col-md-6">
														
														<select id="watermark_image" name="watermark_image" class="selectpicker">
															<?php
																if($handle = opendir('watermarks/')) {
													    			while(false !== ($entry = readdir($handle))) {
													        			if($entry != "." && $entry != ".." && $entry != "index.php") {
													        				echo '<option value="'.$entry.'" data-thumbnail="watermarks/'.$entry.'"">'.$entry.'</option>';
																		}
																	}
																}
															?>
														</select>
													</div>
												</div>
											<?php } ?>

											<div class="form-group">
												<label class="col-md-3 control-label" for="screenshot">Screenshot</label>
												<div class="col-md-6">
													<select id="screenshot" name="screenshot" class="form-control input-sm mb-md">
														<option <?php if($source['config']['screenshot']=='enable'){echo"selected";} ?> value="enable">Enable</option>
														<option <?php if($source['config']['screenshot']=='disable'){echo"selected";} ?> value="disable">Disable</option>
													</select>
												</div>
											</div>

											<?php if($source['config']['screenshot'] == 'enable') { ?>
												<div class="col-md-4">
												</div>

												<div class="form-group col-md-4">
													<span class="border border-primary rounded">
														<img src="screenshots/video0.png" alt="" height="240" width="320">
													</span>
												</div>
											<?php } ?>
										</div>

										<footer class="panel-footer">
											<a href="dashboard.php?c=sources" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success">Submit</button>
										</footer>
									</form>
								</section>
							</div>
						</div>
						<!-- end: page -->
					</section>
				<?php } ?>

				<?php function watermarks() { ?>
					<section role="main" class="content-body">
						<header class="page-header">
							<h2>Watermarks</h2>

							<div class="right-wrapper pull-right">
								<ol class="breadcrumbs">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
										</a>
									</li>
									<li><span>Watermarks</span></li>
								</ol>
						
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>

						<!-- start: page -->
						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions"></div>
										<h2 class="panel-title">Add new Watermark</h2>
									</header>
									<div class="panel-body">
										<form action="actions.php?a=watermark_upload" method="post" enctype="multipart/form-data">
										    Select image to upload:
										    <input type="file" name="fileToUpload" id="fileToUpload">
										    <input type="submit" value="Upload Image" name="submit">
										</form>
									</div>
								</section>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions"></div>
										<h2 class="panel-title">Watermark Images</h2>
									</header>
									<div class="panel-body">
										<div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
											<?php
												if ($handle = opendir('watermarks/')) {

												    while (false !== ($entry = readdir($handle))) {

												        if ($entry != "." && $entry != ".." && $entry != "index.php") {

												            echo '
																<div class="isotope-item document col-sm-4 col-md-4 col-lg-4">
																	<div class="thumbnail">
																		<div class="thumb-preview">
																			<center>
																				<img src="watermarks/'.$entry.'" class="img-responsive" alt="Watermarks" style="max-height:200px; max-width:200px; height:auto; width:auto;">
																			</center>
																			<div class="mg-thumb-options">
																				'.$entry.' <a href="actions.php?a=watermark_delete&watermark='.$entry.'"><i class="fa fa-trash-o"></i> Delete</a>
																			</div>
																		</div>
																	</div>
																</div>
												            ';
												        }
												    }

												    closedir($handle);
												}
											?>
										</div>
									</div>
								</section>
							</div>
						</div>
						<!-- end: page -->
					</section>
				<?php } ?>

				<?php function roku_remotes() { ?>
					<?php 
						$roku_config_files = glob("/var/www/html/addons/roku/config.*.json");
						$count = 1;
					?>

					<section role="main" class="content-body">
						<header class="page-header">
							<h2>ROKU Remote</h2>

							<div class="right-wrapper pull-right">
								<ol class="breadcrumbs">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
										</a>
									</li>
									<li><span>ROKU Remote</span></li>
								</ol>
						
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>

						<!-- start: page -->
						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<form action="actions.php?a=roku_remote_add" class="form-horizontal form-bordered" method="post">
										<header class="panel-heading">
											<div class="panel-actions"></div>
											<h2 class="panel-title">Add new ROKU</h2>
										</header>
										<div class="panel-body">
										    <div class="row">
											    <div class="form-group">
													<label class="col-md-1 control-label" for="name">Name</label>
													<div class="col-md-5">
														<input type="text" class="form-control" id="name" name="name" value="ROKU Streamer #1" placeholder="ROKU Streamer #1">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-1 control-label" for="stream">IP Address</label>
													<div class="col-md-5">
														<input type="text" class="form-control" id="ip_address" name="ip_address" value="" placeholder="192.168.1.10">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-1 control-label" for="app">App / Channel</label>
													<div class="col-md-5">
														<select id="app" name="app" class="form-control input-sm mb-md">
															<option value="">Select One</option>
															<option value="nowtv">NOWTV</option>
															<option value="bbc">BBC iPlayer</option>
															<option value="itv">ITV Hub</option>
														</select>

														<select id="channel" name="channel" class="form-control input-sm mb-md">
															<option value="">Select One</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<footer class="panel-footer">
											<button type="submit" class="btn btn-success">Add</button>
										</footer>
									</form>
								</section>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions"></div>
										<h2 class="panel-title">ROKU Devices</h2>
									</header>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped mb-none">
												<thead>
													<tr>
														<th width="10px">#</th>							<!-- 0 -->
														<th width="100px">Status</th>						<!-- 1 -->
														<th width="100px">Name</th>						<!-- 2 -->
														<th width="50px">IP Address</th>				<!-- 3 -->
														<th width="100px">Active App</th>				<!-- 4 -->
														<th width="100px">Desired Channel</th>			<!-- 5 -->
														<th width="50px">Actions</th>					<!-- 6 -->
													</tr>
												</thead>
												<tbody>
													<?php foreach ($roku_config_files as $roku_config_file) { ?>
														<?php 
															$roku 		= file_get_contents($roku_config_file);
															$roku 		= json_decode($roku, true);
															$active_app = exec('php -q addons/roku/roku.php '.$roku['ip_address'].' active_app');
															$active_app = json_decode($active_app, true);
														?>
														<tr>
															<td valign="center"><?php echo $count; ?></td>
															<td><span class="label label-success" style="100%">Online</span></td>
															<td><?php echo $roku['name']; ?></td>
															<td><?php echo $roku['ip_address']; ?></td>
															<td><?php echo $active_app['app']; ?></td>
															<td><?php echo strtoupper(str_replace('_', ' ', $roku['app'])); ?>: <?php echo ucwords(str_replace('_', ' ', $roku['channel'])); ?></td>
															<td>
																<a title="Restart ROKU" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button>
																<a title="Edit ROKU" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=roku_remote&ip=<?php echo $roku['ip_address']; ?>"><i class="fa fa-gears"></i></a>
															</td>
														</tr>
														<?php $count++; ?>
													<?php } ?>
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

				<?php function roku_remote() { ?>
					<?php $roku['ip_address'] 	= get('ip'); ?>
					<?php 
						$roku['config'] 		= @file_get_contents('addons/roku/config.'.$roku['ip_address'].'.json');
						$roku['config'] 		= json_decode($roku['config'], true);
					?>

					<section role="main" class="content-body">
						<header class="page-header">
							<h2>ROKU Remote > <?php echo $roku['config']['name']; ?></h2>

							<div class="right-wrapper pull-right">
								<ol class="breadcrumbs">
									<li>
										<a href="dashboard.php">
											<i class="fa fa-home"></i>
										</a>
									</li>
									<li>
										<a href="dashboard.php?c=roku_remotes">
											<span>ROKU Remotes</span>
										</a>
									</li>
									<li>
										<a href="dashboard.php?c=roku_remote&ip=<?php echo $roku['ip_address']; ?>">
											<span><?php echo $roku['config']['name']; ?></span>
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
									<form action="actions.php?a=roku_remote_update" class="form-horizontal form-bordered" method="post">
										<input type="hidden" name="existing_ip_address" value="<?php echo $roku['ip_address']; ?>">
										<input type="hidden" name="existing_app" value="<?php echo $roku['config']['app']; ?>">
										<input type="hidden" name="existing_channel" value="<?php echo $roku['config']['channel']; ?>">
										<header class="panel-heading">
											<div class="panel-actions"></div>
											<h2 class="panel-title">Settings</h2>
										</header>
										<div class="panel-body">
											<?php if(isset($_GET['dev']) && $_GET['dev'] == 'yes') { ?>
												<pre>
													<?php print_r($roku); ?>
												</pre>
											<?php } ?>

											<div class="form-group">
												<label class="col-md-3 control-label" for="name">Name</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="name" name="name" value="<?php echo $roku['config']['name']; ?>" required>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="ip_address">IP Address</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="ip_address" name="ip_address" value="<?php echo $roku['config']['ip_address']; ?>" required>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="existing_app_view">Current App / Channel</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="existing_app_view" name="existing_app_view" value="<?php echo strtoupper(str_replace('_', ' ', $roku['config']['app'])).': '.ucwords(str_replace('_', ' ', $roku['config']['channel'])); ?>" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="app">Set New App / Channel</label>
												<div class="col-md-6">
													<select id="app" name="app" class="form-control input-sm mb-md">
														<option value="">Select one or leave blank for no change</option>
														<option value="nowtv">NOWTV</option>
														<option value="bbc">BBC iPlayer</option>
														<option value="itv">ITV Hub</option>
													</select>

													<select id="channel" name="channel" class="form-control input-sm mb-md">
														<option value="">Select one or leave blank for no change</option>
													</select>
												</div>
											</div>
										</div>

										<footer class="panel-footer">
											<a href="dashboard.php?c=roku_remotes" class="btn btn-default">Back</a>
											<button type="submit" class="btn btn-success">Submit</button>
										</footer>
									</form>
								</section>
							</div>
						</div>
						<!-- end: page -->
					</section>
				<?php } ?>

				<?php function test() { ?>
					<section role="main" class="content-body">
						<header class="page-header">
							<h2>TEST</h2>

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
								<div id="player" class="fixed-controls"  style="width:600px; height:338px;"></div>

								<script>
									var api = flowplayer("#player", {
									    live: true,
									    splash: true,
									    clip: {
									        sources: [
									            {
									                type: "application/x-mpegurl",
									                src: "http://192.168.1.50:9000/hls/video0.m3u8"
									            }
									        ],
									        title: "LiveStream"
									    },
									    embed: {
									        skin: "http://releases.flowplayer.org/6.0.1/skin/bauhaus.css"
									    }
									});
								</script>
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
			<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
			<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
			
			<!-- Specific Page Vendor -->
			<script src="assets/vendor/pnotify/pnotify.custom.js"></script>
			
			<!-- Theme Base, Components and Settings -->
			<script src="assets/javascripts/theme.js"></script>
			
			<!-- Theme Custom -->
			<script src="assets/javascripts/theme.custom.js"></script>
			
			<!-- Theme Initialization Files -->
			<script src="assets/javascripts/theme.init.js"></script>

		</section>

		<script>

			<?php if(!empty($_SESSION['alert']['status'])){ ?>
				new PNotify({
					title: 'Success!',
					text: '<?php echo $_SESSION['alert']['message']; ?>',
					type: '<?php echo $_SESSION['alert']['status']; ?>'
				});
		        <?php unset($_SESSION['alert']); ?>
		    <?php } ?>


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
								// set some static values
								if(sources[i].source.video_codec == 'libx264') {
									sources[i].source.video_codec = 'H.264';
								}
								if(sources[i].source.video_codec == 'libx265') {
									sources[i].source.video_codec = 'H.265';
								}
								if(sources[i].source.video_codec == 'not_set') {
									sources[i].source.video_codec = '';
								}

								if(sources[i].source.resolution == 'not_set') {
									sources[i].source.resolution = '';
								}

								if(sources[i].source.audio_device == 'not_set') {
									sources[i].source.audio_device = '';
								}

								if(sources[i].source.rtmp_server == 'not_set') {
									sources[i].source.rtmp_server = '';
								}

								if(sources[i].source.audio_codec == 'aac') {
									sources[i].source.audio_codec = 'AAC';
								}

								if(sources[i].source.audio_codec == 'not_set') {
									sources[i].source.audio_codec = '';
								}

								if(sources[i].source.bitrate == 'not_set') {
									sources[i].source.bitrate = '';
								} else {
									sources[i].source.bitrate = sources[i].source.bitrate + 'k';
								}

								if(sources[i].source.output_type == 'rtmp') {
									sources[i].source.stream_url = 'RTMP: ' + sources[i].source.rtmp_server;
								}
								if(sources[i].source.output_type == 'http') {
									sources[i].source.stream_url = 'HTTP: ' + sources[i].source.http_server;
								}

								if(sources[i].source.status == 'busy') {
									// colum 1
									document.getElementById(sources[i].source.name + '_col_1').innerHTML = '<span class="label label-success" style="100%">Streaming</span>';

									// colum 2
									document.getElementById(sources[i].source.name + '_col_2').innerHTML = sources[i].source.name;

									// colum 3
									document.getElementById(sources[i].source.name + '_col_3').innerHTML = sources[i].source.video_codec;

									// colum 4
									document.getElementById(sources[i].source.name + '_col_4').innerHTML = sources[i].source.resolution;

									// colum 5
									document.getElementById(sources[i].source.name + '_col_5').innerHTML = sources[i].source.audio_codec;

									// colum 6
									document.getElementById(sources[i].source.name + '_col_6').innerHTML = sources[i].source.bitrate;

									// colum 7
									document.getElementById(sources[i].source.name + '_col_7').innerHTML = sources[i].source.stream_url;

									// colum 8
									document.getElementById(sources[i].source.name + '_col_8').innerHTML = sources[i].source.uptime;

									// colum 9
									document.getElementById(sources[i].source.name + '_col_9').innerHTML = '<button onclick="source_stop(\''+sources[i].source.name+'\')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-pause"></i></button> <button onclick="source_restart(\''+sources[i].source.name+'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-refresh"></i></button> <a title="Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=source&source=' + sources[i].source.name + '"><i class="fa fa-gears"></i></a>';
								} else {
									// colum 1
									document.getElementById(sources[i].source.name + '_col_1').innerHTML = '<span class="label label-danger" style="100%">Not Streaming</span>';

									// colum 2
									document.getElementById(sources[i].source.name + '_col_2').innerHTML = sources[i].source.name;

									// colum 3
									document.getElementById(sources[i].source.name + '_col_3').innerHTML = sources[i].source.video_codec;

									// colum 4
									document.getElementById(sources[i].source.name + '_col_4').innerHTML = sources[i].source.resolution;

									// colum 5
									document.getElementById(sources[i].source.name + '_col_5').innerHTML = sources[i].source.audio_codec;

									// colum 6
									document.getElementById(sources[i].source.name + '_col_6').innerHTML = sources[i].source.bitrate;

									// colum 7
									document.getElementById(sources[i].source.name + '_col_7').innerHTML = sources[i].source.stream_url;

									// colum 8
									document.getElementById(sources[i].source.name + '_col_8').innerHTML = sources[i].source.uptime;

									// colum 0
									document.getElementById(sources[i].source.name + '_col_9').innerHTML = '<button onclick="source_start(\''+sources[i].source.name+'\')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-play"></i></button> <button disable class="btn btn-primary btn-flat btn-xs"><i class="fa fa-refresh"></i></button> <a title="Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=source&source=' + sources[i].source.name + '"><i class="fa fa-gears"></i></a>';
								}
							}						
						}
					});
				}, 10000);
			<?php } ?>

			function source_start(source) {
				var question = confirm("Please allow up to 60 seconds for the stream to start.");
				if( question == true ) {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=source_start&source=' + source,
						success: function(sources) {
							new PNotify({
								title: 'Success!',
								text: source+' stream has been started.',
								type: 'success'
							});
						}
					});
					return true;
				}
			}

			function source_stop(source) {
				var question = confirm("Please confirm you want to stop streaming this source.");
				if( question == true ) {
					$.ajax({
						cache: false,
						type: "GET",
				        url:'actions.php?a=source_stop&source=' + source,
						success: function(sources) {
							new PNotify({
								title: 'Success!',
								text: source+' stream has been stopped.',
								type: 'success'
							});
						}
					});
					return true;
				}
			}
		</script>

		<script src="assets/javascripts/ui-elements/examples.modals.js"></script>

		<script src="assets/javascripts/bootstrap-select.js"></script>
		<script>
			$(document).ready(function() {
				// Initiate with custom caret icon
				$('select.selectpicker').selectpicker( {
					caretIcon: 'glyphicon glyphicon-menu-down'
				});
			});

			$(document).ready(function () {
			    $("#app").change(function () {
			        var val = $(this).val();
			        if (val == "nowtv") {
			            $("#channel").html("<option value='sky_one'>Sky One</option><option value='sky_witness'>Sky Witness</option><option value='sky_atlantic'>Sky Atlantic</option><option value='gold'>GOLD</option><option value='comedy_central'>Comedy Central</option><option value='syfy'>SyFy</option><option value='sky_arts'>Sky Arts</option><option value='discovery_channel'>Discovery Channel</option><option value='fox'>FOX</option><option value='mtv'>MTV UK</option><option value='wild'>WILD</option><option value='cartoon_network'>Cartoon Network UK</option><option value='boomerang'>Boomerang</option><option value='nickelodean'>Nickelodean</option><option value='nick_toons'>Nick Toons</option><option value='nick_jr'>Nick Jr</option><option value='cartoonito'>Cartoonito</option><option value='sky_cinema_premiere'>Sky Cinema Premiere</option><option value='sky_cinema_megahits'>Sky Cinema Megahits / Hits</option><option value='sky_cinema_greats'>Sky Cinema Greats</option><option value='sky_cinema_disney'>Sky Cinema Disney</option><option value='sky_cinema_family'>Sky Cinema Family</option><option value='sky_cinema_action'>Sky Cinema Action</option><option value='sky_cinema_comedy'>Sky Cinema Comedy</option><option value='sky_cinema_thriller'>Sky Cinema Thriller</option><option value='sky_cinema_drama'>Sky Cinema Drama</option><option value='sky_cinema_scifi'>Sky Cinema SciFi</option><option value='sky_cinema_select'>Sky Cinema Select</option>");
			        } else if (val == "bbc") {
			            $("#channel").html("<option value='bbc_one'>BBC One</option><option value='bbc_two'>BBC Two</option><option value='bbc_four'>BBC Four</option><option value='bbc_news'>BBC News</option><option value='bbc_parliament'>BBC Parliament</option><option value='bbc_alba'>BBC Alba</option><option value='bbc_s4c'>BBC S4c</option><option value='bbc_cbeebies'>BBC CBeebies</option><option value='bbc_cbbc'>BBC CBBC</option>");
			        } else if (val == "itv") {
			            $("#channel").html("<option value='itv_one'>ITV 1</option><option value='itv_two'>ITV 2</option><option value='itv_three'>ITV 3</option><option value='itv_four'>ITV 4</option><option value='itv_be'>ITV Be</option><option value='citv'>CITV</option>");
			        } else if (val == "") {
			        	$("#channel").html("<option value=''>Select an App first</option>");
			        }
			    });
			});
		</script>
	</body>
</html>