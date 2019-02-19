<?php

$raw = shell_exec('/root/speedtest-cli --simple');

$speedtest_bits = explode("\n", $raw);

$speedtest_bits = array_filter($speedtest_bits);

$ping = explode(": ", $speedtest_bits[0]);
$data['ping'] = $ping[1]);

$download = explode(": ", $speedtest_bits[1]);
$data['download'] = $download[1]);

$upload = explode(": ", $speedtest_bits[2]);
$data['upload'] = $upload[1]);

print_r($data);