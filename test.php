<?php

$audio_devices 			= exec('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');


echo "printing results \n";
print_r($audio_devices);