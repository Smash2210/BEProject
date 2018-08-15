<?php

session_start();
$username = $_GET['Username'];
$_SESSION['username'] = $username;
$_SESSION['password'] = $_GET['Pass'];
header('Location: dashboard.php');


?>