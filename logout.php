<?php
session_start();

session_destroy();

go($site['url'].'/index.php');