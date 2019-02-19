<?php

$speedtest = shell_exec('/root/speedtest-cli --simple');

print_r($speedtest);