<?php

// build default config file
$config['login']['username'] = "admin";
$config['login']['password'] = "admin";

// convert array to json
$json = json_encode($config);

// write config
file_put_contents('config.json', $json);