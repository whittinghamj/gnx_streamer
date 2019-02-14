<?php

$audio_devices 			= exec('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');


echo "printing results \n";
echo $audio_devices;

echo "\n\n";