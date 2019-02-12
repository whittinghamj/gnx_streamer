<?php
include('../inc/global_vars.php');
include('../inc/functions.php');

$task = $argv[1];

if($task == 'test')
{
	console_output("Parsing config files");
	
	$files = glob("/var/www/html/config/*.json");

	print_r($files);
}
