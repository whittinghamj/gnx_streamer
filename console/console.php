<?php

include('/var/www/html/inc/global_vars.php');
include('/var/www/html/inc/functions.php');

$task = $argv[1];

if($task == 'stop_start')
{
	console_output("Stop / Start Streams.");
	
	$config_files = glob("/var/www/html/config/video*.json");

	foreach($config_files as $config_file) {
		$file = file_get_contents($config_file);
		$data = json_decode($file, true);

		// print_r($data);

		$cmd = "ffmpeg -nostdin -loglevel fatal -y -f alsa -ac 2 -i hw:1,0 -f video4linux2 -re -framerate ".$data['framerate_in']." -i /dev/".$data['source']." -acodec aac -ab 128k -ar 44100 -f matroska -vcodec ".$data['video_codec']." -r ".$data['framerate_out']." -pix_fmt yuv422p -s ".$data['screen_resolution']." -preset ultrafast -b:v ".$data['bitrate']."k -f flv ".$data['rtmp_server']." ".($data['screenshot']=='enable' ? '-f image2 -vf fps=fps=90 -s 320x240 -updatefirst 1 /var/www/html/screenshots/video0.png' : '');

		// echo "====================================================================================================\n";
		// echo $cmd . "\n";
		// echo "====================================================================================================\n";

		// echo "\n";

		$pid = exec("ps aux | grep '/dev/".$data['source']."' | grep -v 'grep' | grep -v '0:00' | awk '{print $2}'");

		// stream is enabled and no pid
		if($data['stream'] == 'enable' && empty($pid)) {
			// found a dead stream, lets start it again
			echo "Starting stream for ".$data['source']." \n";
			shell_exec('sudo nohup ' . $cmd . ' > '.$data['source'].'.log 2>&1 &');
		}elseif($data['stream'] == 'enable' && !empty($pid)){
			// do nothing, we found a stream already running for this source
			echo "Stream already running for ".$data['source']." with PID: ".$pid." \n";
		}

		// stream set to disable, lets find and kill it
		if($data['stream'] == 'disable' && !empty($pid)) {
			echo "Stopping stream for ".$data['source']." with PID: ".$pid." \n";
			exec('sudo kill -9 ' . $pid);
		}else{
			// echo "No stream running for ".$data['source']." \n";
		}
	}
}
