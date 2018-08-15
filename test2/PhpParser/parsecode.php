<?php

require_once 'spout-2.7.3/src/Spout/Autoloader/autoload.php';
// $host = 'myserver35.database.windows.net';
// $username = 'swapnil';
// $password = 'pass@123';
// $db_name = 'mydb';
// ini_set ('error_reporting', E_ALL);
// ini_set ('display_errors', '1');
// error_reporting (E_ALL|E_STRICT);
 
// $db_ca_cert = realpath('cert/MyServe.pem');
// $conn = mysqli_init();
// mysqli_ssl_set($conn, NULL, NULL, $db_ca_cert, NULL, NULL);
// $link = mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
//Establishes the connection

// mysqli_real_connect($conn, $host, $username, $password, $db_name);
// if (mysqli_connect_errno($conn)) {
// die('Failed to connect to MySQL: '.mysqli_connect_error());
// }

$pathname = $_POST['pathname'];
$rowstart = $_POST['rowstart'];
$rowend = $_POST['rowend'];
$hostname = $_POST['hostname'];
$username = $_POST['Username'];
$password = $_POST['Password'];
$dbname = $_POST['dbname'];

$conn=mysqli_connect($hostname,$username,$password,$dbname);

$db = mysqli_select_db($conn,$dbname);

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$reader = ReaderFactory::create(Type::XLSX); // for XLSX files

$reader->open($pathname);
$count = 0;
foreach ($reader->getSheetIterator() as $sheet) {
	 if ($sheet->getName() === 'Online Retail') {
    	foreach ($sheet->getRowIterator() as $row) {
    		++$count;
    		if($rowstart<=$count && $rowend>=$count) 
        	{
        		if($count>1){
        		$dt = date_format($row[4],'d-m-Y H:i');
        		$sql = "Insert into dataset(InvoiceNo, StockCode,Description, Quantity, InvoiceDate, UnitPrice, CustomerID,Country) values ($row[0], '$row[1]','$row[2]', $row[3], '$dt', $row[5], $row[6], '$row[7]')";
        		
        		}
        		else
        		{
        			$sql = "Insert into dataset values ($row[0], '$row[1]','$row[2]', $row[3], '$row[4]', $row[5], $row[6], '$row[7]')";
        		}
        		//echo $sql."<br/>";
        		$res = mysqli_query($conn,$sql);
                // mysqli_stmt_execute($res);
        		if(!$res){
        			echo "Terminated at $count";
        			
        		}
        	}
        	if($count>$rowend)
        		break;
    	}
    }
}

$reader->close();

?>