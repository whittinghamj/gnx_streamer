<?php
include('../inc/global_vars.php');
include('../inc/functions.php');

$task = $argv[1];

if($task == 'test')
{
	console_output("Parsing config files");
	
	$config_files = glob("/var/www/html/config/video*.json");

	foreach($config_files as $config_file) {
		$data = json_decode($config_file);

		print_r($data);

		$cmd = "ffmpeg -y -f alsa -ac 2 -i hw:1,0 -f video4linux2 -re -framerate 29 -i /dev/video0 -acodec aac -ab 128k -ar 44100 -f matroska -vcodec libx264 -r 30 -pix_fmt yuv420p -s 1280x720 -preset ultrafast -b:v 4000k -f flv rtmp://iptv.genexnetworks.net:25462/live/sky_cinema_comedy_hd -f image2 -vf fps=fps=90 -s 320x240 -updatefirst 1 /var/www/html/screenshots/video0.png";

		echo "==================================================\n";
		echo $cmd;
		echo "==================================================\n";

		echo "\n";
	}
}
