<?php

$audio_devices 			= shell_exec('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');
$array 					= explode("\n", $audio_devices);
$result 				= array_filter($array);
print_r($result);