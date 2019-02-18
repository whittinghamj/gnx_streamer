<?php

// build sample config file
$config[0]['name'] 			= "Demo ROKU #1";
$config[0]['ip_address'] 	= "192.168.1.180";
$config[0]['channel'] 		= "sky_cinema_hits";
$config[1]['name'] 			= "Demo ROKU #2";
$config[1]['ip_address'] 	= "192.168.1.182";
$config[1]['channel'] 		= "sky_cinema_comedy";

// convert array to json
$json = json_encode($config);

// write config
file_put_contents('config.json', $json);