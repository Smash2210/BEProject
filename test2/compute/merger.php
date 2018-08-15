<?php
	session_start();
	$username = $_SESSION['username'];
	include "../includes/connect.php";
	// session_start();
	$sql = "Select * from user_login where username = '$username'";
	$res = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($res);
	$ftp_user_name = $row['ftp_username'];
	$ftp_user_pass = $row['ftp_password'];
	$ftp_server = $row['hostname'];
	$domain = $row['domain'].'/itemset.json';
	if(!@file_get_contents('http://'.$domain)){
	    $prev_items = array();
	}
	else{
	$prev_items = json_decode(file_get_contents('http://'.$domain),true);
	}
	$frag1 = json_decode($_POST['frag1'],true);
	$frag2 = json_decode($_POST['frag2'],true);
	$temp = array();
	foreach ($frag1 as $key => $value) {
		if(array_key_exists($key, $frag2) && array_key_exists($key, $prev_items)){
			$temp = array_merge($temp, array("$key"=>($value+$frag2[$key]+$prev_items[$key])*1.0/3));
		}
		elseif (array_key_exists($key, $prev_items)) {
			$temp = array_merge($temp, array("$key"=>($value+$prev_items[$key])*1.0/2));
		}
		elseif (array_key_exists($key, $frag2)) {
			$temp = array_merge($temp, array("$key"=>($value+$frag2[$key])*1.0/2));
		}
		else{
			$temp = array_merge($temp, array("$key"=>($value)));
		}
	}
	foreach ($frag2 as $key => $value) {
		if(array_key_exists($key, $prev_items[$key]) && !array_key_exists($key, $frag1[$key])){
			$temp = array_merge($temp, array("$key"=>($value+$prev_items[$key])*1.0/2));
		}
		else if(!array_key_exists($key, $prev_items[$key]) && !array_key_exists($key, $frag1[$key])){
			$temp = array_merge($temp,array("$key"=>$value));
		}
	}
	foreach ($prev_items as $key => $value) {
			if(!array_key_exists($key, $frag1) && !array_key_exists($key, $frag2))
			$temp = array_merge($temp, array("$key"=>$value));
	}
	$temp = array_unique($temp);
	$json_content = json_encode($temp);
	$savelog = "itemset.json";
	$handle1 = fopen($savelog, 'w') or die('Cannot open file:  '.$savelog);
	
	fwrite($handle1, $json_content);
	fclose($handle1);
	
	/*considering prev items*/

	// print_r($ftp_server);
	$file1 = "itemset.json";//tobe uploaded
	$remote_file1 = "../public_html/itemset.json";
	$conn_id = ftp_connect($ftp_server);
	if(!@ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)){
	
	exit();
	}
	ftp_put($conn_id, $remote_file1, $file1, FTP_ASCII);
	ftp_close($conn_id);
	$savelog = "itemset.json";
	$handle1 = fopen($savelog, 'w') or die('Cannot open file:  '.$savelog);
	
	fwrite($handle1, '{}');
	fclose($handle1);

?>