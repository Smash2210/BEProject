<?php


include "connect.php";


// include "connect.php";
$handle = fopen('user_meta.json', 'r') or die("Could not open");
$data = fread($handle, filesize('user_meta.json'));
$data = json_decode($data,true);
// fclose($handle);
// var_dump($data);
if(array_key_exists("processed", $data)){
	$sql = "Select * from dataset where sr>".$data["processed"];
}
else{
	$sql = "select * from dataset";
}
fclose($handle);
$handle = fopen('user_meta.json', 'w') or die("Could not open");
$arr = array();

 
$res = mysqli_query($conn,$sql);
 
if(array_key_exists("processed", $data)){
	$data["processed"] += mysqli_num_rows($res);
}
else{
	$data["processed"] =  mysqli_num_rows($res);
}

$arr += array("processed"=>$data["processed"]);
$a = json_encode($arr);
fwrite($handle, $a);
if(array_key_exists("processed", $data)){
	unset($result);
}
$result = array();
 $qty_tracker = array();
 $temp = array();
 while($row = mysqli_fetch_array($res)){
 	// print_r($row);
 	array_push($result, 
 	array(($row[1]) =>  array('Productname' => $row[3], 'Quantity'=>$row[4])));
 	
 	if(array_key_exists($row[3], $qty_tracker)){
 		$temp = array($row[3]=>($qty_tracker[$row[3]]+$row[4]));
 	}else{
 		$temp = array($row[3]=>$row[4]);
 	}
 	$qty_tracker += $temp;
 }

 
 if(file_exists('qty_tracker.json')){
 // print_r("expression");
 $handle1 = fopen('qty_tracker.json','r');
 $data1 = json_decode(fread($handle1, filesize('qty_tracker.json')),true);
 foreach ($qty_tracker as $key => $value) {
 	if(array_key_exists($key, $data1)){
 		$temp = array($key=>($value+$data1[$key]));
 	}
 	else{
 		$temp = array($key=>$value);
 	}
 	$data1 += $temp;
 }
 fclose($handle1);
	$handle1 = fopen('qty_tracker.json', 'w');
	fwrite($handle1, json_encode($data1));
	fclose($handle1);
}else{
	$handle1 = fopen('qty_tracker.json', 'w');
	$data1 = array();
	$data1 += $qty_tracker;
	fwrite($handle1, json_encode($data1));
	fclose($handle1);
}


 echo json_encode(array('result'=>$result));


 
 mysqli_close($conn);




?>