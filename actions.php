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

	case "source_check":
		source_check();
		break;

	case "source_stop":
		source_stop();
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
	$data['source']['command'] 		= exec('ps -eo args | grep "/dev/'.$source.'" | grep -v "grep" | grep -v "0:00" |head -n -1');
	$data['source']['command']		= str_replace("sh -c ", "", $data['source']['command']);
	$data['source']['pid']			= exec("ps aux | grep 'dev/".$source."' | grep -v 'grep' | grep -v '0:00' | awk '{print $2}'");

	echo json_encode($data);
}

function source_stop() {
	$pid = get('pid');

	exec('sudo kill -9 ' . $pid);

	echo "Killing " . $pid;

	die();

	status_message('success', 'Card has stopped streaming.');
	
	go($_SERVER['HTTP_REFERER']);
}