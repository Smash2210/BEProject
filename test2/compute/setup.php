<?php
include '../connect.php';
 session_start();
 if(!isset($_SESSION['username'])){
    header('Location: ../login.php');
 }
 else{
    $username = $_SESSION['username'];
 $ch = "Select updatedDetailsCheck from user_login where username='$username'";
 $res = mysqli_query($conn,$ch);
 $r = mysqli_fetch_array($res);
 if($r['updatedDetailsCheck']==1){
    $q = "Select * from user_login where username='$username'";
    $rr = mysqli_query($conn, $q);
    $result = mysqli_fetch_array($rr);
    // var_dump($result);
    $hostname = $result['hostname'];
    $db_id = $result['db_id'];
    $db_password = $result['db_password'];
    $db_name = $result['dbname'];
    $ftp_server=$hostname;
    $ftp_user_name=$result['ftp_username'];
    $ftp_user_pass=$result['ftp_password'];
    $handle = fopen("Send/".$username."-connect.php", 'w') or die("Could not create temp file");
    $data = '<?php $conn=mysqli_connect("localhost","'.$db_id.'","'.$db_password.'","'.$db_name.'");$db = mysqli_select_db($conn,"'.$db_name.'"); ?>';
    fwrite($handle, $data);
    $file1 = "Send/fetch.php";//tobe uploaded
    $remote_file1 = "../public_html/fetch.php";
    $file2 = "Send/algorithm.php";//tobe uploaded
    $remote_file2 = "../public_html/algorithm.php";
    $file3 = "Send/content.json";//tobe uploaded
    $remote_file3 = "../public_html/content.json";
    $file4 = "Send/user_meta.json";//tobe uploaded
    $remote_file4 = "../public_html/user_meta.json";
    $file5 = "Send/".$username."-connect.php";//tobe uploaded
    $remote_file5 = "../public_html/connect.php";
    $file6 = "Send/clear-content.php";//tobe uploaded
    $remote_file6 = "../public_html/clear-content.php";
    $file7 = "Send/client-handler.php";//tobe uploaded
    $remote_file7 = "../public_html/client-handler.php";
 // set up basic connection
 $conn_id = ftp_connect($ftp_server);

 // login with username and password
if(!@ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)){
    echo "false";
    exit();
}
 // upload a file
 if (ftp_put($conn_id, $remote_file1, $file1, FTP_ASCII)) {
    if (ftp_put($conn_id, $remote_file2, $file2, FTP_ASCII)) {
        if (ftp_put($conn_id, $remote_file3, $file3, FTP_ASCII)) {
            if (ftp_put($conn_id, $remote_file4, $file4, FTP_ASCII)) {
                if (ftp_put($conn_id, $remote_file5, $file5, FTP_ASCII)) {
                    
                    unlink("Send/".$username."-connect.php");
                    if (ftp_put($conn_id, $remote_file6, $file6, FTP_ASCII)) {
                        if (ftp_put($conn_id, $remote_file7, $file7, FTP_ASCII)) {
                            echo "true";
                            exit();
                        }
                    }
                }
            }
        }
    }
 } else {
    echo "false";
    exit;
    }
 // close the connection
 ftp_close($conn_id);
 }
 else{
    echo "-1";
 }

}
 ?>