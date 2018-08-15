<?php
    session_start();
    include "../includes/connect.php";
    $username = $_SESSION['username'];
    $sql = "Select domain from user_login where username = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $domain = $row['domain'];
    $prev_items = json_decode(file_get_contents('http://'.$domain.'/itemset.json'),true);
    $data = array();
    $total_sup = 0;
    $qty_sum = 0;
    foreach ($prev_items as $key => $value) {
        $total_sup += $value;
    }
    $qty = json_decode(file_get_contents('http://'.$domain.'/qty_tracker.json'),true);
    foreach ($prev_items as $key => $value) {
        $elements = explode(";", $key);
        foreach ($elements as $val) {
            $qty_sum += $qty[$val];
        }
        $temp = array("x"=>$qty_sum,"y"=>$value,"z"=>(($value*100.00)/$total_sup), "country"=>$key);
        array_push($data, $temp);
    }
    echo json_encode($data);

?>