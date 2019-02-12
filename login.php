<?php
session_start();

include('inc/global_vars.php');
include('inc/functions.php');

// read the config file
$config_raw 		= @file_get_contents('config.json');
$config 			= json_decode($config_raw);

$username 			= post('username');
$password 			= post('password');

// login check
if($username = $config['login']['username'] && $password = $config['login']['password']){
	go('dashboard');
}else{
	go('index');
}

?>