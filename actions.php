<?php
session_start();

include("inc/global_vars.php");
include("inc/functions.php");

$a = $_GET['a'];

switch ($a)
{
	case "test":
		test();
		break;
	
	case "get_system_stats":
		get_system_stats();
		break;

	case "ajax_source_list":
		ajax_source_list();
		break;

	case "source_check":
		source_check();
		break;

	case "source_stop":
		source_stop();
		break;

	case "source_start":
		source_start();
		break;

	case "source_update":
		source_update();
		break;
			
// default
				
	default:
		home();
		break;
}

function home(){
	die('access denied to function name ' . $_GET['a']);
}

function test(){
	echo exec('whoami');
	echo "<hr>";
	echo '<h3>$_SESSION</h3>';
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_POST</h3>';
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_GET</h3>';
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
	echo '<hr>';
}

function get_system_stats() {
	header("Content-Type:application/json; charset=utf-8");

	$data = exec('sudo sh /var/www/html/system_stats.sh');

	$data = json_decode($data, true);

	$data['cpu_usage'] = str_replace("%", "", $data['cpu_usage']);
	$data['cpu_usage'] = number_format($data['cpu_usage'], 2);

	$data['ram_usage'] = str_replace("%", "", $data['ram_usage']);
	$data['ram_usage'] = number_format($data['ram_usage'], 2);

	$data['disk_usage'] = str_replace("%", "", $data['disk_usage']);
	$data['disk_usage'] = number_format($data['disk_usage'], 2);

	echo json_encode($data);
}

function source_check() {
	header("Content-Type:application/json; charset=utf-8");

	$source = get('source');

	if(empty($source)) {
		$data['status'] = 'error';
		$data['message'] = 'source was blank.';
		echo json_encode($data);
		die();
	}

	$source_check 					= exec("sudo sh /var/www/html/source_check.sh ".$source);

	$data['status'] 				= 'success';
	$data['source']['name'] 		= $source;
	$data['source']['status'] 		= $source_check;
	$data['source']['command'] 		= exec('ps -eo args | grep "/dev/'.$source.'" | grep -v "grep" | grep -v "0:00"');
	$data['source']['command']		= str_replace("sh -c ", "", $data['source']['command']);
	$data['source']['pid']			= exec("ps aux | grep 'dev/".$source."' | grep -v 'grep' | grep -v '0:00' | awk '{print $2}'");

	if(file_exists('config/'.$source.'.json')) {
		$config_file 						= @file_get_contents('config/'.$source.'.json');
		$config_file 						= json_decode($config_file, true);
		
		$data['source']['resolution']		= $config_file['screen_resolution'];
		$data['source']['video_codec']		= $config_file['video_codec'];
		$data['source']['bitrate']			= $config_file['bitrate'];
		$data['source']['screenshot']		= $config_file['screenshot'];
		$data['source']['framerate_in']		= $config_file['framerate_in'];
		$data['source']['framreate_out']	= $config_file['framerate_out'];
		$data['source']['rtmp_server']		= $config_file['rtmp_server'];
	}else{
		$data['source']['resolution']		= 'not_set';
		$data['source']['video_codec']		= 'not_set';
		$data['source']['bitrate']			= 'not_set';
		$data['source']['screenshot']		= 'not_set';
		$data['source']['framerate_in']		= 'not_set';
		$data['source']['framerate_out']	= 'not_set';
		$data['source']['rtmp_server']		= 'not_set';
	}

	// output
	echo json_encode($data);
}

function source_stop() {
	$source = get('source');

	// read, update, write config file
	$config_file 			= @file_get_contents('config/'.$source.'.json');
	$config_file	 		= json_decode($config_file, true);
	$config_file['stream']	= 'disable';
	$json = json_encode($config_file);
	file_put_contents('config/'.$source.'.json', $json);
	
	// find and kill pid
	$pid 					= exec("ps aux | grep 'dev/".$source."' | grep -v 'grep' | grep -v '0:00' | awk '{print $2}'");
	exec('sudo kill -9 ' . $pid);

	// status message
	// status_message('success', 'Card has stopped streaming.');
	
}

function source_start() {
	$source = get('source');

	// read, update, write config file
	$config_file 			= @file_get_contents('config/'.$source.'.json');
	$config_file	 		= json_decode($config_file, true);
	$config_file['stream']	= 'enable';
	$json = json_encode($config_file);
	file_put_contents('config/'.$source.'.json', $json);

	// status message
	// status_message('success', 'Card will start streaming soon.');
}

function ajax_source_list() {
	header("Content-Type:application/json; charset=utf-8");

	$video_cards 			= glob("/dev/video*");

	foreach($video_cards as $video_card) {
		$raw['name'] 			= str_replace("/dev/", "", $video_card);
		$raw['raw_json']		= file_get_contents("http://localhost/actions.php?a=source_check&source=".$raw['name']);
		$raw['source_status']	= json_decode($raw['raw_json'], true);

		$sources[] 				= $raw['source_status'];
	}

	echo json_encode($sources);
}

function source_update() {
	header("Content-Type:application/json; charset=utf-8");

	if(empty($_POST['audio_sample_rate'])) {
		$_POST['audio_sample_rate'] = 44100;
	}

	if(empty($_POST['audio_bitrate'])) {
		$_POST['audio_bitrate']	= 128;
	}

	$json = json_encode($_POST);

	file_put_contents('config/'.$_POST['source'].'.json', $json);

	status_message('success', 'Configuration saved..');

	if($_POST['stream'] == 'enable') {
		file_get_contents('actions.php?a=source_stop&source='.$_POST['source']);
		file_get_contents('actions.php?a=source_start&source='.$_POST['source']);
	}
	
	go($_SERVER['HTTP_REFERER']);
}