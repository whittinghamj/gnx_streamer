<?php
session_start();

include('inc/global_vars.php');
include('inc/functions.php');

// read the config file
$config_raw 		= @file_get_contents('config.json');
$config 			= json_decode($config_raw);

$login['username'] 			= post('username');
$login['password'] 			= post('password');

debug($config);
debug($login);

// login check
if($login['username'] == $config['login']['username'] && $login['password'] == $config['login']['password']){
	echo 'login passed <br>';
	go('dashboard');
}else{
	echo 'login failed <br>';
	go('index');
}

?>