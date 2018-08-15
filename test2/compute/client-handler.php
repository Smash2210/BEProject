<?php
	//This is the URL of the remote script that need to be executed
	$url = 'http://client-application2.000webhostapp.com/fetch.php';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 0); // return headers 0 no 1 yes

	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.8");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	$a = array('res' => $result);
	$result = json_decode($result,true);
	// $a = json_decode($a,true);
	// var_dump($a);
	if(!empty($result['result'])){
          
    $url = 'http://client-application2.000webhostapp.com/algorithm.php';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 0); // return headers 0 no 1 yes
	// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.8");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $a );
	$result = curl_exec($ch);
	curl_close($ch);

	print_r($result);
        }
	

?>