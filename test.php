<?php

$speedtest = exec('/root/speedtest-cli --simple');

print_r($speedtest);