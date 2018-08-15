<?php 

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://client-application2.000webhostapp.com/algorithm.php');
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$response = curl_exec($curl);
$status = curl_getinfo($curl);
curl_close($curl);
print_r($response);

?>