<?php
    // $strt = microtime(true);
    //Grab previous itemset if exists
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
    $flag = 0;
    $data1 = $_POST['res'];
    // $handle = fopen('content.json', 'r') or die('Cannot open file:');
    // $data1 = fread($handle, filesize('content.json'));
    $res = json_decode($data1,true);
    // var_dump($res);
    if(file_exists('UserData//'.$username.'transactions.json')){
    $handle2 = fopen('UserData//'.$username.'transactions.json','r') or die('Cannot open file!');
    if(filesize('UserData//'.$username.'transactions.json')!=0){
    $transactions = fread($handle2, filesize('UserData//'.$username.'transactions.json'));
    $transactions = json_decode($transactions,true);
    }
    else{
        $transactions = array();
        $transactions += $res;
    }
    fclose($handle2);
    }
    else{

        $transactions = array();
        $transactions += $res;
    }
    foreach ($res as $value) {
        array_push($transactions,$value);    
    }
    
    // $club_transaction = array();
    // $club_transaction += $transactions;
    // var_dump($transactions);
    $handle2 = fopen('UserData//'.$username.'transactions.json','w') or die('Cannot open file!');
    fwrite($handle2, json_encode($transactions));
    fclose($handle2);
    // var_dump($res);
    // print_r("Previous Items:<br>");
    // var_dump($prev_items);
    if(empty($prev_items)){
        $flag = 1;
    }
    $freq = compute($res,$transactions);
    // print_r("1::::");
    // var_dump($club_transaction);
    $result_itemset = array();
    if($flag==0){
        if(empty($freq)){
            $update_list = array();
            foreach ($prev_items as $key => $value) {
                $update_list = array($key=>1);
            }
            foreach ($update_list as $key => $value) {
                if(array_key_exists($key, $transactions)){
                    $update_list[$key]++;
                }
            }
            foreach ($update_list as $key => $value) {
                $update_list[$key] = round($value/count($transactions),3);
            }
            $result_itemset = $update_list;
        }
        else{
        
        foreach ($freq as $key => $value) {
           if(array_key_exists($key, $prev_items)){
            $result_itemset = array_merge($result_itemset,array($key=>round(($value+$prev_items[$key])/2.0,3)));
           }
           else{
            $result_itemset = array_merge($result_itemset,array($key=>($value)));
           }
        }
    }

        $freq = array();
        $freq += $result_itemset;
    //     $k=0;

    //     $compute_global = array_merge($freq, $prev_items);
    //     // var_dump($freq);
    //     // var_dump($prev_items);
    //     // var_dump($compute_global);
    //     if(empty($freq)){
    //         $freq = $compute_global;
    //         // print_r("expression");
    //     }
    //     else{
    //         $tempo = array();
    //     foreach ($compute_global as $key => $value) {
    //         $tempo[$k] = $key;
    //         $k++;
    //     }
    //     $freq = compute($tempo,$club_transaction);

    // }
        $flag = 1;
    }
    // else{
    //         $result_itemset = array();
    //         $result_itemset += $prev_items;
    //     }
    //     $freq = array();
    //     $freq += $result_itemset;
    $json_content = json_encode($freq);
    $savelog = "itemset.json";
    $handle1 = fopen($savelog, 'w') or die('Cannot open file:  '.$savelog);
    
    fwrite($handle1, $json_content);
    fclose($handle1);
    include "../includes/connect.php";
    // session_start();

    $username = $_SESSION['username'];
    $sql = "Select * from user_login where username = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $ftp_user_name = $row['ftp_username'];
    $ftp_user_pass = $row['ftp_password'];
    $ftp_server = $row['hostname'];
    // print_r($ftp_server);
    $file1 = "itemset.json";//tobe uploaded
    $remote_file1 = "../public_html/itemset.json";
    $conn_id = ftp_connect($ftp_server);
    if(!@ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)){
    
    exit();
    }
    ftp_put($conn_id, $remote_file1, $file1, FTP_ASCII);
    ftp_close($conn_id);
    $savelog = "itemset.json";
    $handle1 = fopen($savelog, 'w') or die('Cannot open file:  '.$savelog);
    
    fwrite($handle1, '{}');
    fclose($handle1);
    function compute($res,$transactions){
        $content = array();
        $array1 =  array();
        $array2 = array();
        $result = array();
        // $username = $_SESSION['username'];
        // if(file_exists($username.'-transactions.json')){
        // $handle2 = fopen($username.'-transactions.json','r') or die('Cannot open file!');
        // if(filesize($username.'transactions.json')!=0){
        // $transactions = fread($handle2, filesize($username.'transactions.json'));
        // $transactions = json_decode($transactions,true);
        // }
        // else{
        //     $transactions = array();
        // }
        // fclose($handle2);
        // }
        // else{
        //     $transactions = array();
        // }
        // var_dump($res);
        if(!empty($res))
        for($i=0;$i<count($res)-1;$i++){
        for($j=$i+1;$j<count($res);$j++){
            unset($array1);
            unset($array2);
            unset($result);
            $array1 = explode(";", $res[$i]);
            $array2 = explode(";", $res[$j]);
            $result = array_intersect($array1, $array2);
            if(empty($result)){
                continue;
            }
            sort($result);
            $ans = implode(";", $result);
            // print_r($ans."<br>");
            
            
                $count = 0;
                // foreach ($content as $key => $value) {
                //     $a = explode(";", $key);
                //     $b = explode(";", $ans);
                //     $c = array_intersect($a, $b);
                //     // print_r(var_dump($a)."    ".var_dump($b)."    ".var_dump($c));
                //     if($c == $b){
                //         $count++;
                    
                //     }
                //     if($a==$c){
                //         $content[$key] +=1;
                //     }
                // }
               
                // print_r(count($transactions));
                if(array_key_exists($ans, $content)){
                    continue;
                }
                for($m=0;$m<count($transactions);$m++){
                    if((strpos($transactions[$m], $ans))!== false){
                        $count++;
                    }
                }
                $content += array("$ans"=>$count);
            
        }
    }
    $freq = array();
    foreach ($content as $key => $value) {
        // $i = 1;
        // $sum = 0;
        // $c = 0;
        // while ($sum<$value) {
        //     $sum += $i;
        //     $c++;
        //     $i++;
        // }
        if($value>1 && count(explode(";", $key))>1)
        $freq += array("$key"=>round(($value*100.0)/count($transactions),3));
    }
    return $freq;
    }
?>