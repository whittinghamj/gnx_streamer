<?php

function filesize_formatted($path) {
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function check_whmcs_status($userid) {
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["responsetype"] 		= "json";
	$postfields["action"] 			= "getclientsproducts";
	$postfields["clientid"] 			= $userid;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data = json_decode($data);
	$api_result = $data->result;
	// $clientid = $data->clientid;
	// $product_name = $data->products->product[0]->name;
	$product_status = strtolower($data->products->product[0]->status);
	
	if($product_status != 'active'){
		
		// forward to billing area
		$whmcsurl = "https://billing.boudoirsocial.com/dologin.php";
		$autoauthkey = "admin1372";
		$email = clean_string($_SESSION['account']['email']);
		
		$timestamp = time(); 
		$goto = "clientarea.php";
		
		$hash = sha1($email.$timestamp.$autoauthkey);
		
		$url = $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
		
		go($url);
	}
}

function account_details($billing_id) {
	// get local account data 
	$query = "SELECT * FROM `users` WHERE `id` = '".$billing_id."' " ;
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){	
		$results['user_id']					= $row['id'];
		$results['email']					= $row['email'];
		$results['username']				= $row['email'];
		$results['firstname']				= $row['firstname'];
		$results['lastname']				= $row['lastname'];
		$results['account_type']			= $row['account_type'];
		$results['avatar']					= $row['avatar'];
	}
		
	return $results;
}

function check_products($billing_id) {
	global $whmcs, $site;
	
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["responsetype"] 		= "json";
	$postfields["action"] 			= "getclientsproducts";
	$postfields["clientid"] 			= $billing_id;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data = json_decode($data);
	$api_result = $data->result;
	
	return $data->products->product;
	// $clientid = $data->clientid;
	// $product_name = $data->products->product[0]->name;
	//$product_status = strtolower($data->products->product[0]->status);
}

function get_other_user_details($billing_id) {
	/*
	global $whmcs;
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["action"] 			= "getclientsdetails";
	$postfields["clientid"] 			= $billing_id;	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data = explode(";",$data);
	foreach ($data AS $temp) {
	  $temp = explode("=",$temp);
	  $results[$temp[0]] = $temp[1];
	}
	
	if ($results["result"]=="success"){
		*/
		// get local account data 
		$query = "SELECT * FROM users WHERE billing_id = '".$billing_id."' " ;
		$result = mysql_query($query) or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$results['user_id'] 			= $row['user_id'];
			$results['username'] 		= stripslashes($row['username']);
			$results['gender'] 			= $row['gender'];
			$results['dob']				= $row['dob'];
			$results['account_type'] 	= $row['account_type'];
			$results['last_login']		= $row['last_login'];
			$results['photo'] 			= $row['photo'];
			if(empty($row['photo'])){
				if($row['gender'] == 'male'){
					$results['photo'] = 'img/male_avatar.jpg';
				}elseif($row['gender'] == 'female'){
					$results['photo'] = 'img/female_avatar.png';
				}else{
					$results['photo'] = 'img/default_avatar.jpg';
				}
			}
			
			$results['paid_photo_charge'] 	= stripslashes($row['paid_photo_charge']);
			$results['paid_video_charge'] 	= stripslashes($row['paid_video_charge']);
			
			$results['per_min_video_fee'] 	= stripslashes($row['per_min_video_fee']);
			$results['per_min_phone_fee'] 	= stripslashes($row['per_min_phone_fee']);	
						
			$results['tagline'] 				= stripslashes($row['tagline']);
			$results['description'] 			= stripslashes($row['description']);
			$results['verified'] 			= $row['verified'];
			
			$results['facebook'] 			= stripslashes($row['facebook']);
			$results['twitter'] 				= stripslashes($row['twitter']);
			$results['skype'] 				= stripslashes($row['skype']);
			$results['youtube'] 				= stripslashes($row['youtube']);
			
			$results['city'] 				= stripslashes($row['city']);
			$results['state'] 				= stripslashes($row['state']);
			$results['country'] 				= stripslashes($row['country']);
			
		}
		
		// livecam online status
		$query = "SELECT * FROM boudoirsocial_livecam.vc_session WHERE username = '".$results['username']."' " ;
		$result = mysql_query($query) or die(mysql_error());
		$livecam = mysql_num_rows($result);
		if($livecam == 1){
			$results['livecam'] = 'online';
		}else{
			$results['livecam'] = 'offline';
		}	
		
		return $results;
	// }
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

function debug_die($input) {
	die(debug($input));
}

function mysql_disconnect() {
	global $connection;
	mysql_close($connection);
}

function get_product_ids($uid) {
	global $whmcs;
	$url 						= $whmcs['url'];
	$postfields["username"] 		= $whmcs['username'];
	$postfields["password"] 		= $whmcs['password'];
	$postfields["responsetype"] = "json";
	$postfields["action"] 		= "getclientsproducts";
	$postfields["clientid"] 		= $uid;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data = json_decode($data);
	$api_result = $data->result;
		
	foreach($data->products->product as $product_data){
		$pids[] = $product_data->pid;
	}
	
	return $pids;
}

function status_message($status, $message){
	$_SESSION['alert']['status']			= $status;
	$_SESSION['alert']['message']		= $message;
}

function active_product_check($needles, $haystack) {
   return !!array_intersect($needles, $haystack);
}

function show_my_profile_products($account_details) {
	global $whmcs, $site;
	
	foreach($account_details['products'] as $product){
		$status = $product->status;
		if($status == 'Active'){
			$status = 'green';
		}else{
			$status = 'red';
		}
		
		echo '
			<tr>
				<td>'.$product->name.'</td>
				<td><span class="badge bg-'.$status.'">'.$product->status.'</span></td>
			</tr>
		';	
	}
}

function call_remote_content($url) {
	echo file_get_contents($url);
}

function show_headends() {
	global $account_details;

	$query = "SELECT * FROM `headends` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC";
	$result = mysql_query($query) or die(mysql_error());
	// $data['query'] = $query;
	// echo print_r($data);
	while($row = mysql_fetch_array($result)){
		$data['id']							= $row['id'];
		$data['name']						= stripslashes($row['name']);
		$data['ip_address']					= stripslashes($row['ip_address']);
		$data['controller_ip_address']		= stripslashes($row['controller_ip_address']);
		$data['location']					= stripslashes($row['location']);
		$data['sources']					= stripslashes($row['sources']);
		$data['status_raw']					= $row['status_raw'];


		if($data['status_raw'] == 'online')
		{
			echo '
				<tr>
					<th>
						'.$data['name'].' <br>
						<span style="font-weight:normal;">
							'.$data['location'].'
						</span>
					</th>
					<th>
						'.$data['controller_ip_address'].'
					</th>
					<th>
						'.$data['sources'].'
					</th>
					
					<td class="pull-right">
						<a title="Overview" class="btn btn-primary btn-flat" href="?c=headend&headend_id='.$data['id'].'"><i class="fa fa-globe"></i></a>
						<a title="Delete Headend" class="btn btn-danger btn-flat" onclick="return confirm(&#039;Are you sure you want to do this?&#039;);" href="actions.php?a=headend_delete&headend_id='.$data['id'].'"><i class="fa fa-times"></i></a>
					</td>
				</tr>
			';
		}else{
			echo '
				<tr>
					<th>
						'.$data['name'].' <br>
						<span style="font-weight:normal;">
							'.$data['location'].'
						</span>
					</th>
					<th>
						'.($data['unifi']['status_raw']=='not_configured' ? 
							$data['unifi']['status'] : 
							$data['unifi']['status'].' <span style="font-weight:normal;"><small>(Uptime: '.$data['unifi']['router_uptime'].')</small></span> <br>
							<span style="font-weight:normal;">
								<b>WAN IP:</b> '.$data['unifi']['router_wan_ip'].' <small>(<i class="fas fa-download"></i> '.$data['unifi']['router_wan_rx'].' | <i class="fas fa-upload"></i>'.$data['unifi']['router_wan_tx'].')</small><br>
								<b>LAN IP:</b> '.$data['unifi']['router_lan_ip'].'
							</span>
						').'
					</th>
					<th>
						'.$data['sources'].'
					</th>
					
					<td>
						<a title="Overview" class="btn btn-primary btn-flat" href="?c=site&site_id='.$data['id'].'"><i class="fa fa-globe"></i></a>
						<a title="Delete Site" class="btn btn-danger btn-flat" onclick="return confirm(&#039;Are you sure you want to do this?&#039;);" href="actions.php?a=site_delete&site_id='.$data['id'].'"><i class="fa fa-times"></i></a>
					</td>
				</tr>
			';
		}

		unset($data);
	}
}

function get_headend($headend_id) {
	// get asic miners
	$query = "SELECT * FROM `headends` WHERE `id` = '".$headend_id."' ";
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$data['id']							= $row['id'];
		$data['user_id']					= $row['user_id'];
		$data['name']						= stripslashes($row['name']);
		$data['ip_address']					= stripslashes($row['ip_address']);
		$data['controller_ip_address']		= stripslashes($row['controller_ip_address']);
		$data['location']					= stripslashes($row['location']);
		$data['sources']					= stripslashes($row['sources']);
		$data['status_raw']					= $row['status_raw'];
		$data['sources']					= get_sources($headend_id);
	}
	
	return $data;
}

function show_sources($headend_id) {
	global $account_details;

	$query = "SELECT * FROM `sources` WHERE `headend_id` = '".$headend_id."' ORDER BY `name` ASC";
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$data['id']							= $row['id'];
		$data['headend_id']					= $row['headend_id'];
		$data['name']						= stripslashes($row['name']);
		$data['location']					= stripslashes($row['location']);
		$data['ip_address']					= stripslashes($row['ip_address']);
		$data['type']						= stripslashes($row['type']);
		$data['make']						= stripslashes($row['make']);
		$data['model']						= stripslashes($row['model']);
		$data['assigned_channel']			= stripslashes($row['assigned_channel']);
		$data['status']						= stripslashes($row['status']);
		$data['hostname']					= stripslashes($row['hostname']);


		echo '
			<tr>
				<th>
					'.$data['name'].'
				</th>
				<th>
					'.($data['status'] == 'online' ? '<font color="green">Online</font>' : '<font color="red">Pffline</font>').'
				</th>
				<th>
					'.$data['hostname'].'
				</th>
				<th>
					'.ucfirst($data['type']).'
				</th>
				<th>
					'.$data['make'].' / '.$data['model'].'
				</th>
				<th>
					'.ucwords(str_replace("_", " ", $data['assigned_channel'])).'
				</th>
				<td class="pull-right">
					<a title="Overview" class="btn btn-primary btn-flat" href="?c=source&source_id='.$data['id'].'"><i class="fa fa-globe"></i></a>
					<a title="Delete" class="btn btn-danger btn-flat" onclick="return confirm(&#039;Are you sure you want to do this?&#039;);" href="actions.php?a=source_delete&source_id='.$data['id'].'"><i class="fa fa-times"></i></a>
				</td>
			</tr>
		';

		unset($data);
	}
}

function get_sources($headend_id) {
	// get asic miners
	$query = "SELECT * FROM `sources` WHERE `headend_id` = '".$headend_id."' ";
	$result = mysql_query($query) or die(mysql_error());
	$count = 0;
	while($row = mysql_fetch_array($result)){
		$data[$count]['id']							= $row['id'];
		$data[$count]['headend_id']					= $row['headend_id'];
		$data[$count]['name']						= stripslashes($row['name']);
		$data[$count]['location']					= stripslashes($row['location']);
		$data[$count]['ip_address']					= stripslashes($row['ip_address']);
		$data[$count]['type']						= stripslashes($row['type']);
		$data[$count]['make']						= stripslashes($row['make']);
		$data[$count]['model']						= stripslashes($row['model']);
		$data[$count]['assigned_channel']			= stripslashes($row['assigned_channel']);
		$data[$count]['status']						= stripslashes($row['status']);

		$count++;
	}
	
	return $data;
}

function get_source($headend_id) {
	// get asic miners
	$query = "SELECT * FROM `sources` WHERE `headend_id` = '".$headend_id."' ";
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$data['id']							= $row['id'];
		$data['headend_id']					= $row['headend_id'];
		$data['name']						= stripslashes($row['name']);
		$data['location']					= stripslashes($row['location']);
		$data['ip_address']					= stripslashes($row['ip_address']);
		$data['type']						= stripslashes($row['type']);
		$data['make']						= stripslashes($row['make']);
		$data['model']						= stripslashes($row['model']);
		$data['assigned_channel']			= stripslashes($row['assigned_channel']);
		$data['status']						= stripslashes($row['status']);
		$data['hostname']					= stripslashes($row['hostname']);
		$data['headend']					= get_headend($data['headend_id']);
	}
	
	return $data;
}

function show_servers() {
	global $account_details;

	$query = "SELECT * FROM `servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC";
	$result = mysql_query($query) or die(mysql_error());
	// $data['query'] = $query;
	// echo print_r($data);
	while($row = mysql_fetch_array($result)){
		$data['id']							= $row['id'];
		$data['name']						= stripslashes($row['name']);
		$data['ip_address']					= stripslashes($row['ip_address']);
		$data['hostname']					= stripslashes($row['hostname']);
		
		$data['cpu_usage']					= str_replace("%", "", stripslashes($row['cpu_usage']));
		$data['cpu_usage']					= number_format($data['cpu_usage'], 0);
		if($data['cpu_usage'] >= 80){
			$data['cpu_usage'] = '<font color="red">'.$data['cpu_usage'].'</font>';
			$row_background = '#eecdcd';
		}

		$data['ram_usage']					= str_replace("%", "", stripslashes($row['ram_usage']));
		$data['ram_usage']					= number_format($data['ram_usage'], 0);
		if($data['ram_usage'] >= 80){
			$data['ram_usage'] = '<font color="red">'.$data['ram_usage'].'</font>';
			$row_background = '#eecdcd';
		}

		$data['disk_usage']					= str_replace("%", "", stripslashes($row['disk_usage']));
		$data['disk_usage']					= number_format($data['disk_usage'], 0);
		if($data['disk_usage'] >= 80){
			$data['disk_usage'] = '<font color="red">'.$data['disk_usage'].'</font>';
			$row_background = '#eecdcd';
		}

		$data['bandwidth_up']				= number_format($row['bandwidth_up'] / 125, 2);
		$data['bandwidth_down']				= number_format($row['bandwidth_down'] / 125, 2);
		$data['uptime']						= stripslashes($row['uptime']);
		$data['uuid']						= stripslashes($row['uuid']);
		$data['status']						= stripslashes($row['status']);
		$status_time_diff					= time() - $row['last_updated'];
		if($status_time_diff > 120){
			$data['status']					= 'offline';
			$row_background 				= '#eecdcd';
		}

		$data['type']						= ucfirst($row['type']);

		echo '
			<tr bgcolor="'.$row_background.'">
				<td>
					<strong>Status:</strong> '.($data['status']=='online' ? '<font color="green">Online</font>' : '<font color="red">Offline</font>').' <br>
					<strong>Name:</strong> '.$data['name'].' <br>
					<strong>Type:</strong> '.$data['type'].'
				</td>
				<td>
					<strong>IP:</strong> '.$data['ip_address'].' <br>
					<strong>Host:</strong> '.$data['hostname'].'
				</td>
				<td>
					<strong>Download:</strong> '.$data['bandwidth_down'].' Mbit<br>
					<strong>Upload:</strong> '.$data['bandwidth_up'].' Mbit<br>
				</td>
				<td>
					<strong>CPU: '.$data['cpu_usage'].'% </strong><br>
					<strong>RAM: '.$data['ram_usage'].'% </strong><br>
					<strong>DISK: '.$data['disk_usage'].'% </strong><br>
				</td>
				<td class="pull-right">
					<a title="Overview" class="btn btn-primary btn-flat" href="?c=headend&headend_id='.$data['id'].'"><i class="fa fa-globe"></i></a>
					<a title="Delete Headend" class="btn btn-danger btn-flat" onclick="return confirm(&#039;Are you sure you want to do this?&#039;);" href="actions.php?a=headend_delete&headend_id='.$data['id'].'"><i class="fa fa-times"></i></a>
				</td>
			</tr>
		';

		$row_background = '';

		unset($data);
	}
}