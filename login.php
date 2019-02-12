<?php
session_start();

include('inc/global_vars.php');
include('inc/functions.php');

// read the config file
$config_raw 		= @file_get_contents('config.json');
$config 			= json_decode($config_raw);

$login['username'] 			= post('username');
$login['password'] 			= post('password');

print_r($login);

// login check
if($username = $config['login']['username'] && $password = $config['login']['password']){
	go('dashboard');
}else{
	go('index');
}

?>