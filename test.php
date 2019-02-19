<?php

$raw = shell_exec('/root/speedtest-cli --simple');

$speedtest_bits = explode("\n", $raw);

print_r($speedtest_bits);