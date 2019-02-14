<?php

$audio_devices 			= passthru('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');


echo "printing results \n";
echo $audio_devices;

echo "\n\n";