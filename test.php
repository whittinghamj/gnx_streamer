<?php

$source['name']				= 'video0';
$source['raw_json']			= file_get_contents("actions.php?a=source_check&source=".$source['name']);

echo '<pre>';
print_r($source);