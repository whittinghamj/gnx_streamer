<?php
include('../inc/global_vars.php');
include('../inc/functions.php');

$task = $argv[1];

if($task == 'test')
{
	console_output("Parsing config files");
	
	$config_files = glob("/var/www/html/config/video*.json");

	foreach($config_files as $config_file) {
		$data = json_decode($config_file);

		print_r($data);
	}
}
