<?php
	session_start();
	include "includes/connect.php";
	$username = $_SESSION['username'];
    $sql = "Select domain from user_login where username = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $domain = $row['domain'].'/itemset.json';
    $data = file_get_contents('http://'.$domain);
    if(!@json_decode($data) || $data==='{}'){
    	echo "No data";
    }
    else{
    	echo $data;
    }
?>