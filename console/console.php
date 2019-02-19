<?php

include('/var/www/html/inc/global_vars.php');
include('/var/www/html/inc/functions.php');

$task = $argv[1];

if($task == 'cron') {
	
	// roku remote cron
	console_output("ROKU Remotes Addon");
	$roku_config_files = glob("/var/www/html/addons/roku/config.*.json");

	if(!is_array($roku_config_files)) {
		console_output(" - No ROKU device config files found.");
	}else{
		foreach($roku_config_files as $roku_config_file) {
			$roku 		= file_get_contents($roku_config_file);
			$roku 		= json_decode($roku, true);
			$active_app = exec('php -q addons/roku/roku.php '.$roku['ip_address'].' active_app');
			$active_app = json_decode($active_app, true);

			if(empty($active_app)) {
				console_output(" - ROKU device appears to be offline, skipping.");
			}else{
				console_output(" - Setting ROKU App / Channel.");
				// console_output(" - sudo php -q /var/www/html/addons/roku/roku.php ".$roku['ip_address']." ".$roku['app']." ".$roku['channel']);
				exec("sudo php -q /var/www/html/addons/roku/roku.php ".$roku['ip_address']." ".$roku['app']." ".$roku['channel']);
			}
		}
	}

	console_output("Finished.");
}

if($task == 'stop_start') {
	console_output("Stop / Start Streams.");
	
	$config_files = glob("/var/www/html/config/video*.json");

	foreach($config_files as $config_file) {
		$file = file_get_contents($config_file);
		$data = json_decode($file, true);

		// print_r($data);

		if($data['output_type'] == 'rtmp') {
			$output_url = $data['rtmp_server'];
		}elseif($data['output_type'] == 'http'){
			$output_url = 'rtmp://localhost/show/' . $data['source'];
		}

		if($data['watermark_type'] == 'disable') {
			$watermark = '';
		}else{
			$watermark = '-i watermarks/'.$data['watermark_image'].' -filter_complex "overlay=10:10" ';
		}

		if($data['screenshot'] == 'enable') {
			$screenshot = '-f image2 -vf fps=fps=90 -s 320x240 -updatefirst 1 /var/www/html/screenshots/'.$data['source'].'.png';
		}else{
			$screenshot = '';
		}

		/*
		dual output streams
		ffmpeg -y -f alsa -ac 2 -i hw:CARD=Device,DEV=0 -f video4linux2 -re -framerate 29 -i /dev/video0 -i watermarks/rsz_logo_1192.png -filter_complex "overlay=10:10" \
			-acodec aac -ab 128k -ar 44100 -f matroska -vcodec libx264 -r 29 -pix_fmt yuv420p -s 1280x720 -preset ultrafast -b:v 3500k -f flv rtmp://localhost/show/video0_hd \
			-acodec aac -ab 128k -ar 44100 -f matroska -vcodec libx264 -r 29 -pix_fmt yuv420p -s 640x480 -preset ultrafast -b:v 1500k -f flv rtmp://localhost/show/video0_sd \
			*/

		$cmd = "ffmpeg -y -f alsa -ac 2 -i ".$data['audio_device']." -f video4linux2 -re -framerate ".$data['framerate_in']." -i /dev/".$data['source']." ".$watermark." -acodec aac -ab 128k -ar 44100 -f matroska -vcodec ".$data['video_codec']." -r ".$data['framerate_out']." -pix_fmt yuv420p -s ".$data['screen_resolution']." -preset ultrafast -b:v ".$data['bitrate']."k -f flv ".$output_url." ".$screenshot;

		echo "====================================================================================================\n";
		echo $cmd . "\n";
		echo "====================================================================================================\n";
		echo "\n";

		echo "Output URL: " . $output_url . "\n";

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

if($task == 'restart_streams') {
	console_output("Restart All Streams.");

	exec('sudo killall ffmpeg');
}

if($task == 'check_dead_hardware') {
	$raw = exec("dmesg | grep 'xHCI host controller not responding, assume dead' | awk '{print $3}'");

	$raw = substr($raw, 0, -1);

	if(!empty($raw)) {
		echo "Found dead hardware, trying to fix device ".$raw." \n";

		exec('echo -n "'.$raw.'" | tee /sys/bus/pci/drivers/xhci_hcd/unbind');
		exec('echo -n "'.$raw.'" | tee /sys/bus/pci/drivers/xhci_hcd/bind');
	}
}

if($task == 'speedtest') {
	console_output("Running speedtest");
	$raw = shell_exec('/root/speedtest-cli --simple');

	$speedtest_bits = explode("\n", $raw);

	$speedtest_bits = array_filter($speedtest_bits);

	$ping = explode(": ", $speedtest_bits[0]);
	$data['ping'] = $ping[1];

	$download = explode(": ", $speedtest_bits[1]);
	$data['download'] = $download[1];

	$upload = explode(": ", $speedtest_bits[2]);
	$data['upload'] = $upload[1];

	$json = json_encode($data);

	file_put_contents('/var/www/html/config/speedtest.json', $json);
}