<?php
session_start();

include('inc/global_vars.php');
include('inc/functions.php');

session_destroy();

go($site['url'].'/index.php');