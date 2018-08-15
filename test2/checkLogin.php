
<?php

// session_start();
if(@$conn=mysqli_connect("localhost","id5062786_dda","Beproject@123","id5062786_serverdb")){
	// echo "connected to server";
	if(@$db = mysqli_select_db($conn,"id5062786_serverdb")){
		$a = trim($_POST['loginUsername']);
		$b = trim($_POST['loginPassword']);
		if(!empty($a) && !empty($b))
	{
		$query1 = "Select * from user_login";
		$run_post = mysqli_query($conn,$query1);
			while($row = mysqli_fetch_array($run_post))
			{
				
				$enteredpass = md5($b);
				$user = trim($row['username']);
				$pass = trim($row['password']);

				// var_dump($user);
				// var_dump($pass);
				// var_dump($enteredpass);
				// var_dump(strcmp($a,$user));
				// echo strcmp($b,$enteredpass);
				if(strcmp($a,$user)==0 && strcmp($pass,$enteredpass)==0)
				{
					$dt = new DateTime();
    				$dt = $dt->format('Y-m-d H:i:s');
    				$handle = fopen('meta/userInfo.json', 'r') or die("Cannot open file");
    				$data = json_decode(fread($handle, filesize('meta/userInfo.json')),true);
    				$l = $data["$a"]['last-logged-in'];
    				fclose($handle);
    				$handle = fopen('meta/userInfo.json', 'w') or die("Cannot open file");
    				foreach ($data as $key => $value) {
    					if(strcmp($key,$user)==0){
    						// print_r("expression");
    						// $value['last-logged-in'] = "";
    						// echo $value['last-logged-in'];
    						// break;
    						$data["$key"]['last-logged-in'] = "$dt";
    						break;
    					}
    				}
    				// var_dump($data);
    				fwrite($handle, json_encode($data));
					echo "ok".";".$l.";".$pass;
					exit();
					
					
				}
			}
			echo "Sorry!!! You are not yet authorized...";
		
	}	
	else
	{
		// alert("ENTER USERNAME OR PASSWORD");
	}
	}
	else{
		echo "error in db connnection";
	}
	

}
else{
	echo 'error';
}
// 	
?>