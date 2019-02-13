<?php

function console_output($data) {
	$timestamp = date("Y-m-d H:i:s", time());
	echo "[" . $timestamp . "] - " . $data . "\n";
}

function json_output($data) {
	// $data['timestamp']		= time();
	$data 					= json_encode($data);
	echo $data;
	die();
}

function filesize_formatted($path) {
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function percentage($val1, $val2, $precision) {
	$division = $val1 / $val2;
	$res = $division * 100;
	$res = round($res, $precision);
	return $res;
}

function clean_string($value) {
    if ( get_magic_quotes_gpc() ){
         $value = stripslashes( $value );
    }
	// $value = str_replace('%','',$value);
    return mysql_real_escape_string($value);
}

function go($link = '') {
	header("Location: " . $link);
	die();
}

function url($url = '') {
	$host = $_SERVER['HTTP_HOST'];
	$host = !preg_match('/^http/', $host) ? 'http://' . $host : $host;
	$path = preg_replace('/\w+\.php/', '', $_SERVER['REQUEST_URI']);
	$path = preg_replace('/\?.*$/', '', $path);
	$path = !preg_match('/\/$/', $path) ? $path . '/' : $path;
	if ( preg_match('/http:/', $host) && is_ssl() ) {
		$host = preg_replace('/http:/', 'https:', $host);
	}
	if ( preg_match('/https:/', $host) && !is_ssl() ) {
		$host = preg_replace('/https:/', 'http:', $host);
	}
	return $host . $path . $url;
}

function post($key = null) {
	if ( is_null($key) ) {
		return $_POST;
	}
	$post = isset($_POST[$key]) ? $_POST[$key] : null;
	if ( is_string($post) ) {
		$post = trim($post);
	}
	return $post;
}

function get($key = null) {
	if ( is_null($key) ) {
		return $_GET;
	}
	$get = isset($_GET[$key]) ? $_GET[$key] : null;
	if ( is_string($get) ) {
		$get = trim($get);
	}
	return $get;
}

function debug($input) {
	$output = '<pre>';
	if ( is_array($input) || is_object($input) ) {
		$output .= print_r($input, true);
	} else {
		$output .= $input;
	}
	$output .= '</pre>';
	echo $output;
}

function status_message($status, $message) {
	$_SESSION['alert']['status']			= $status;
	$_SESSION['alert']['message']		= $message;
}

function call_remote_content($url) {
	echo file_get_contents($url);
}

function show_installed_devices() {
	$video_cards = glob("/dev/video*");

	$count = 1;

	foreach ($video_cards as $key => $value) {
		$raw['name'] 			= str_replace("/dev/", "", $value);
		$raw['raw_json']		= file_get_contents("http://localhost/actions.php?a=source_check&source=".$raw['name']);
		$raw['source_status']	= json_decode($raw['raw_json'], true);

		$source 				= $raw['source_status'];

		if($source['source']['status'] == 'busy') {
			$status = '<span class="label label-success">In Use</span>';
		}else{
			$status = '<span class="label label-info">Ready to Use</span>';
		}

		echo '
			<tr id="'.$source['source']['name'].'_col">
				<td valign="center" id="'.$source['source']['name'].'_col_0">'.$count.'</td>
				<td valign="center" id="'.$source['source']['name'].'_col_1"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_2"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_3"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_4"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_5"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_6"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_7"></td>
				<td valign="center" id="'.$source['source']['name'].'_col_8"></td>
			</tr>
		';

		$count++;
	}
}