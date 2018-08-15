<?php
session_start();
if(isset($_SESSION['username'])){
include "includes/connect.php";
$username = trim($_SESSION['username']);
$hostname = $_POST['hostname'];
$ftp_username = $_POST['ftp_username'];
$ftp_password = $_POST['ftp_password'];
$db_name = $_POST['db_name'];
$db_id = $_POST['db_id'];
$db_password = $_POST['db_password'];
$db_tablename = $_POST['db_tablename'];
$domain = $_POST['domain-name'];

$update = "Update user_login SET hostname='$hostname', ftp_username = '$ftp_username', ftp_password = '$ftp_password', dbname = '$db_name', db_id = '$db_id', db_password='$db_password', db_tablename = '$db_tablename',updatedDetailsCheck = 1, domain='$domain' where username = '$username' ";
$run = mysqli_query($conn,$update);
if($run){
	
	echo "ok";

	exit();
}
else{
	echo "-1";
}

}
else{
	header('Location: login.php');
}
?>