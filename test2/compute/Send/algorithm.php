<?php
    $content = array();
    $res = $_POST['res'];
    $res = json_decode($res,true);
    $len = count($res['result']);
    // $handle = fopen('content.json', 'r') or die('Cannot open file:');
    // $data1 = fread($handle, filesize('content.json'));
    // if (!empty($data1)) {

                // @json_decode($data1);

                // if(json_last_error() === JSON_ERROR_NONE){
                //   $content = json_decode($data1,true);
                  
                    $temp = array();
                    $count = 0;
                    $invoice = array_keys($res['result'][0]);
                   for($i=1;$i<$len;$i++)
                    foreach ($res['result'][$i] as $key => $value) {
                      
                      $id = $key;
                      $prodname = $res['result'][$i][$key]['Productname'];
                      $qty = $res['result'][$i][$key]['Quantity'];
                      if($invoice === $id){
                        $content[$count-1] = $content[$count-1].";".$prodname; 
                      }
                      else{
                        $temp2 = array($prodname);
                        $content = array_merge($content, $temp2);
                        $count++;
                        $invoice = $id;
                      }
        // array_push($temp, 
        //    array($prodname=>array("id"=>$id,"qty"=>$qty)));

       //$temp = array($prodname => array("id"=>$id,"qty"=>$qty),);
        
                      // if(array_key_exists($prodname, $content)){
                      //   $temp = array($prodname=>array("id"=>$content[$prodname]['id']." ".$id,"qty"=>$content[$prodname]['qty']+$qty));
                      //   $content = array_merge($content,$temp);
                      //  }
                      //   else{
                      //     $temp = array($prodname=>array("id"=>$id,"qty"=>$qty));
                      //     $content = array_merge($content,$temp);
                      //   }

        
      
    }
    // fclose($handle);
    $json_content =  json_encode($content);
    $savelog = "content.json";
    $handle = fopen($savelog, 'w') or die('Cannot open file:  '.$savelog);
    
    fwrite($handle, $json_content);
    fclose($handle);
    echo json_encode($content);
    
        //         };

        // }else

        // echo("Error parsing json!!");
    // print($len);
   // $data = array();
    // $i = 0;
    // print_r($res['result']);
    // for($i=0,$j=1;$i<$len;$i++,$j++){
    // // foreach ($res['result'][$i][$j] as $key => $value) {
    //    //print_r( "Key:".$key." Val:".$value."<br/>");
      
    //    if(array_key_exists($res['result'][$i][$j]['Productname'],$data)){

    //    $str = $data[$res['result'][$i][$j]['Productname']];
    //      print_r($str);
    //   //$qyt = $data[$i][$res['result'][$i][$j]['Productname']]['Quantity'] + $qty =$res['result'][$i][$j]['Quantity'];
    //   // $temp = array($res['result'][$i][$j]['Productname'] => array('tid' => $str,'Quantity' => $qty ));
    //   // array_replace($data, $temp);
    //   // print_r($str);
    // }
    //   else{
    //     //$data[$res['result'][$i][$j]['Productname']] = $j;
    //     //$str =$data[$i][$res['result'][$i][$j]['Productname']];
    //     $qty =$res['result'][$i][$j]['Quantity'];
    //     //$data[$res['result'][$i][$j]['Productname']] = $str;
    //     array_push($data, 
    //       array(($res['result'][$i][$j]['Productname'])=>array('tid' => $j,'Quantity' => $qty )));
        
    //   }
      
      
     // }

   // }
// code to use
    
   // print_r($data);
   // var_dump($data);
  // print_r($data['44']);
  // echo json_encode(array('data'=>$data));
    //print_r($data);
    // window.open("algorithm.php","_blank");
        /*var len = Object.keys(data.result).length
        for(var j = 0; j<len ; j++)
        $.each(data.result[j], function(key, val){

            dict[key] = val;

        });
        
        
        for(var key in dict )
        str = str + "<br> key:" + key + " val:" + dict[key];
        $('#output').html("<b>id: </b>"+ str); */
?>
