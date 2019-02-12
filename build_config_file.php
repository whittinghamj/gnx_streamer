<?php

// build default config file
$config['login']['username'] = "admin";
$config['login']['password'] = "admin";

// write config
$json = json_encode($config);

file_put_contents('config.json', $json);