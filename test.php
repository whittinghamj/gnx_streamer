<?php

$audio_devices 			= shell_exec('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');


echo "printing raw results \n";
echo $audio_devices;

echo "\n\n";

echo "printing array results \n";
$array = explode("\n", $audio_devices);
print_r($array);

echo "\n\n";
