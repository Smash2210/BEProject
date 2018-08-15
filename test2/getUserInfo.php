
<?php

	session_start();
	$cur_user = $_SESSION['username'];
	$handle = fopen('meta/userInfo.json', 'r') or die('Cannot open file:');
    $data1 = fread($handle, filesize('meta/userInfo.json'));
    $data1 = json_decode($data1,true);
    foreach ($data1 as $key => $value) {
    	if(strcmp($key,$cur_user)==0){
    		echo json_encode($value);
    		exit();
    	}
    }
    echo "-1";

?>