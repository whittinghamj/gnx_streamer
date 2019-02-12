<?php

$host = '127.0.0.1';
$db   = 'streamer';
$user = 'root';
$pass = 'Mimi!#&@';
$charset = 'utf8mb4';

// $db = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8mb4', $user, 'Mimi!#&@');

$conn = new PDO('mysql:host=127.0.0.1;dbname=streamer;port=3306','root',`Mimi!#&@`);