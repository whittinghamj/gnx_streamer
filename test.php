<?php

$active_app = exec('php -q addons/roku/roku.php 192.168.1.180 active_app');

print_r($active_app);