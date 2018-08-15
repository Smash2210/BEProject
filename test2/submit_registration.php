<?php

include "includes/connect.php";
$username = $_POST['registerUsername'];
$password = $_POST['registerPassword'];
$email = $_POST['registerEmail'];
$enc_pass = md5($password);
$check = "Select username from user_login";
$run = mysqli_query($conn,$check);
while($row = mysqli_fetch_array($run)){
	if(strcmp(trim($row['username']),trim($username))==0){
		echo "-1";
		exit();
	}
}
$query = "insert into user_login (username,password,email) values('$username','$enc_pass','$email')";
$run_post = mysqli_query($conn,$query);
if($run_post){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $enc_pass;
	$temp = array();
	$handle = fopen('meta/userInfo.json', 'r') or die('Cannot open file:');
    $data1 = fread($handle, filesize('meta/userInfo.json'));
    $data1 = json_decode($data1,true);
    fclose($handle);
    $dt = new DateTime();
    $dt = $dt->format('Y-m-d H:i:s');
    $temp = array("$username" => array("last-logged-in" => "$dt", "other"=>"null"));
    $data1 += $temp;
    var_dump($data1);
    $handle = fopen('meta/userInfo.json', 'w') or die('Cannot open file:');
    fwrite($handle, json_encode($data1));
    fclose($handle);
	echo "ok";
}
else{
	echo "-1";
}
?>