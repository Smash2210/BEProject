<?php

session_start();
$username = $_SESSION['username'];
if(file_exists('UserData/'.$username.'transactions.json')){
	$handle = fopen('UserData/'.$username.'transactions.json', 'r') or die("No data");
	$data = fread($handle, filesize('UserData/'.$username.'transactions.json'));
	print_r($data);
}
else{
	print_r("No data");
}