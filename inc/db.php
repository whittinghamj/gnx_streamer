<?php

$host = '127.0.0.1';
$db   = 'streamer';
$user = 'root';
$pass = 'Mimi!#&@';
$charset = 'utf8mb4';

$db = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $user, $pass);