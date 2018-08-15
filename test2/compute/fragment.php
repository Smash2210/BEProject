<?php
session_start();
$username = $_SESSION['username'];
$data = json_decode($_POST['res'],true);
$count = count($data);
// var_dump($data);
$arr = array();
$arr1  = array();
$arr2 = array();
$arr3 = array();
if(file_exists('UserData//'.$username.'transactions.json')){
$handle2 = fopen('UserData//'.$username.'transactions.json','r') or die('Cannot open file!');
if(filesize('UserData//'.$username.'transactions.json')!=0){
$transactions = fread($handle2, filesize('UserData//'.$username.'transactions.json'));
$transactions = json_decode($transactions,true);
}
else{
    $transactions = array();
    $transactions += $data;
}
fclose($handle2);
}
else{

    $transactions = array();
    $transactions += $data;
}
foreach ($data as $value) {
    array_push($transactions,$value);    
}
$handle2 = fopen('UserData//'.$username.'transactions.json','w') or die('Cannot open file!');
fwrite($handle2, json_encode($transactions));
fclose($handle2);
if($count>400){
	$break = $count/2;
	$index = 0;
	while($index<$count){
		if($index<=$break){
			array_push($arr1,$data[$index]);
		}
		else{
			array_push($arr2, $data[$index]);
		}
		
		// else{
		// 	array_push($arr3, $data[$index]);
		// }
		// print_r($data[$index]);
		$index++;
	}
	array_push($arr, $arr1,$arr2);
}
else{
	array_push($arr, $data);
}

if(sizeof($arr)==2){
	$a = json_encode($arr[0]);
	$b = json_encode($arr[1]);
	$t = json_encode($transactions);
	$field1 = array('data'=>urlencode($a),'transactions'=>urlencode($t));
	$field2 = array('data'=>urlencode($b),'transactions'=>urlencode($t));
	$fields_string1 = "";
	$fields_string2 = "";
	foreach ($field1 as $key => $value) {
		$fields_string1 .= $key.'='.$value.'&';
	}
	foreach ($field2 as $key => $value) {
		$fields_string2 .= $key.'='.$value.'&';
	}
	rtrim($fields_string1, '&');
	rtrim($fields_string2, '&');
	// create both cURL resources
	$ch1 = curl_init();
	$ch2 = curl_init();

	// set URL and other appropriate options
	curl_setopt($ch1, CURLOPT_URL, "client-application.000webhostapp.com/Server/test.php");
	curl_setopt($ch1, CURLOPT_HEADER, 0);
	curl_setopt($ch2, CURLOPT_URL, "client-application2.000webhostapp.com/Server/test.php");
	curl_setopt($ch2, CURLOPT_HEADER, 0);
	curl_setopt($ch1,CURLOPT_POST, count($field1));
	curl_setopt($ch1,CURLOPT_POSTFIELDS, $fields_string1);
	curl_setopt($ch2,CURLOPT_POST, count($field2));
	curl_setopt($ch2,CURLOPT_POSTFIELDS, $fields_string2);
	//create the multiple cURL handle
	$mh = curl_multi_init();

	//add the two handles
	curl_multi_add_handle($mh,$ch1);
	curl_multi_add_handle($mh,$ch2);

	$active = null;
	//execute the handles
	do {
	    $mrc = curl_multi_exec($mh, $active);
	} while ($mrc == CURLM_CALL_MULTI_PERFORM);

	while ($active && $mrc == CURLM_OK) {
	    // if (curl_multi_select($mh) != -1) {
	        do {
	            $mrc = curl_multi_exec($mh, $active);
	        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
	    // }
	}

	//close the handles
	curl_multi_remove_handle($mh, $ch1);
	curl_multi_remove_handle($mh, $ch2);
	curl_multi_close($mh);

}
else{
	echo "error";
}
// print_r(json_encode($arr));
?>