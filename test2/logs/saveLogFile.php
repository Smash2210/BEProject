<?php


	$info = $_POST['info'];
	//$info = json_decode(json_encode($info),true);
	$len = count($info['result']);

	$savelog = "meta.txt";
	$handle = fopen($savelog, 'w') or die('Cannot open file:  '.$savelog);
	$data = "Last Processed Record:".$len-1;
	fwrite($handle, $data);
	fclose($handle);
	die("0");

?>