<?php
	// $data = array();
	session_start();
	include "../includes/connect.php";
	$username = $_SESSION['username'];
	    $sql = "Select domain from user_login where username = '$username'";
	    $res = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_array($res);
	    $domain = $row['domain'].'/itemset.json';
	    if(!@file_get_contents('http://'.$domain)){
	        $prev_items = array();
	    }
	    else{
	    $prev_items = json_decode(file_get_contents('http://'.$domain),true);
	}
	if(empty($prev_items)){
		echo("No data");
		exit();
	}
	$data = $prev_items;
	// $data = json_decode($data,true);
	$items = array();
	$elem_count = array();
	foreach ($data as $key => $value) {
		$elements = explode(";", $key);
		foreach ($elements as $val) {
			if(!array_key_exists($val, $items)){
				array_push($items, $val);
				
			}
			
		}
	}

	// var_dump($items);
	
	$combined = array();
	for($i=0;$i<count($items)-1;$i++){
		for($j=$i+1;$j<count($items);$j++){
			$a = $items[$i];
			$b = $items[$j];
			$c = $a.";".$b;
			array_push($combined, $c);
		}
	}
	// var_dump($combined);
	$handle = fopen('UserData//'.$username.'transactions.json','r') or die("Cannot open file");
	$trans = json_decode(fread($handle, filesize('UserData//'.$username.'transactions.json')),true);
	// var_dump($trans);
	foreach ($items as $value) {
		$c = 0;
		foreach ($trans as $v) {
			if(strpos($v,$value)!==false){
				$c++;
			}
		}
		$elem_count = array_merge($elem_count, array($value => $c));
	}
	// var_dump($elem_count);
	$res = array();
	foreach ($combined as $value) {
		$count_ = 0;
		$e = explode(";", $value);
		// var_dump($e);
		foreach ($trans as $v) {
			// var_dump($v);
			$flag = 0;
			foreach ($e as $t) {
				if(strpos($v, $t)===false){
					$flag = 1;
				}
			}
			if($flag==0){
				$count_++;
			}
		}
		if($count_!=0){
			$res = array_merge($res,array($value=>$count_));
		}
	}
	// var_dump($res);
	$op = array();
	foreach ($res as $key => $value) {
		$d = explode(";", $key);
		$i=0;
		foreach ($d as $val) {
			if($i==0){
				$op = array_merge($op, array("Person buys ".$key." together"=>
			 array("Confidence"=>round((($value*1.0)/$elem_count[$val]),3),"Lift"=>round((($value*1.0*count($trans))/($elem_count[$val]*$elem_count[$d[1]])),3))));
			}
			else{
				$op = array_merge($op, array("Person buys ".$key." together"=>
			 array("Confidence"=>round((($value*1.0)/$elem_count[$val]),3),"Lift"=>round((($value*1.0*count($trans))/($elem_count[$d[0]]*$elem_count[$val])),3))));
			}
			
		}
	}
	// var_dump($op);
	function sortit($a,$b) 
	  {

	    return ($a["Confidence"] > $b["Confidence"]) ? -1 : 1;
	  }
	uasort($op, "sortit");
	echo(json_encode($op));

?>