<?php

$audio_devices 			= exec('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');

print_r($audio_devices);