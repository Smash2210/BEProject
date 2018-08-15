<?php
include 'includes/connect.php';
session_start();
$username = $_SESSION['username'];
$sql = "Select * from user_login where username = '$username'";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
$ftp_user_name = $row['ftp_username'];
$ftp_user_pass = $row['ftp_password'];
$ftp_server = $row['hostname'];
// print_r($ftp_server);


$conn_id = ftp_connect($ftp_server);
if(!@ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)){

exit();
}

$dir = "../public_html/user_meta.json";
if(ftp_nlist($conn_id, $dir) == false){
    print_r("false");
}
else{
	print_r("true");
}