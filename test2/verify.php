<?php 
		session_start();
		if(isset($_SESSION['username'])){
			$username = $_SESSION['username'];
		}
		else{
			header('Location: login.php');
		}
        include "includes/connect.php";
        $ch = "Select updatedDetailsCheck from user_login where username='$username'";
        $res = mysqli_query($conn,$ch);
        $r = mysqli_fetch_array($res);
        if($r['updatedDetailsCheck']==1){
        	echo "true";
        }
        else{
        	echo "false";
        }
       

    ?>