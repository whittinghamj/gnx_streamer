<?php
include('../inc/global_vars.php');
include('../inc/functions.php');

$task = $argv[1];

if($task == 'test')
{
	console_output("Stop / Stop Streams.");
	
	$config_files = glob("/var/www/html/config/video*.json");

	foreach($config_files as $config_file) {
		$file = file_get_contents($config_file);
		$data = json_decode($file, true);

		print_r($data);

		$cmd = "ffmpeg -y -f alsa -ac 2 -i hw:1,0 -f video4linux2 -re -framerate ".$data['framerate_in']." -i /dev/".$data['source']." -acodec aac -ab 128k -ar 44100 -f matroska -vcodec ".$data['video_codec']." -r ".$data['framerate_out']." -pix_fmt yuv420p -s ".$data['screen_resolution']." -preset ultrafast -b:v ".$data['bitrate']."k -f flv ".$data['rtmp_server']." ".($data['screenshot']=='enable' ? '-f image2 -vf fps=fps=90 -s 320x240 -updatefirst 1 /var/www/html/screenshots/video0.png' : '');

		echo "====================================================================================================\n";
		echo $cmd . "\n";
		echo "====================================================================================================\n";

		echo "\n";

		if($data['stream'] == 'enable') {
			echo "Starting stream. \n";
			exec('nohup ' . $cmd . ' & ');
		}else{
			echo "stopping stream. \n";
			$pid = exec("ps aux | grep '/dev/".$data['source']."' | grep -v 'grep' | grep -v '0:00' | awk '{print $2}'");
			exec('sudo kill -9 ' . $pid);
		}
	}
}
