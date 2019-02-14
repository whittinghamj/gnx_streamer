<?php

$audio_devices 			= passthru('arecord -L | grep "hw:CARD=SB" | grep -v "plug"');

echo "\n\n";