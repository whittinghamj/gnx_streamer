<?php

// build sample config file
$config[0]['name'] 			= "Demo ROKU #1";
$config[0]['ip_address'] 	= "192.168.1.180";
$config[1]['name'] 			= "Demo ROKU #2";
$config[1]['ip_address'] 	= "192.168.1.182";

// convert array to json
$json = json_encode($config);

// write config
file_put_contents('config.json', $json);