<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');


//  $requestMethod = $_SERVER["REQUEST_METHOD"];
//  if($requestMethod == "GET"){
//     return getData($_GET['phone']);
//  }else if($requestMethod == "POST"){
//     $input=json_decode(file_get_contents("php://input"),true);
//     if(empty($input)){
//         echo myResponseNoData(405);
//     }else{
//         return SaveGalleryImage($input);
//     }
//  }else{
//     echo myResponseNoData(405);
//  }

if(!empty($_POST['phone']))
{
    getData($_POST['phone']);
}


 function getData($phone){
    global $conn;
    // $final_array=array();
     $query = "SELECT * FROM `billing` WHERE `mobile` = '$phone'";
    $query_run = mysqli_query($conn,$query);
    if($query_run){
        
        
        $row_check=mysqli_fetch_assoc($query_run);
        if(!empty($row_check['invo_lbl']))
        {
            $lbl=$row_check['invo_lbl'];
             $file="mehndipvc.shop/mehndi/pdf/$lbl.pdf";
             $arr=array(
                    "url"=>$file,
                 );
                 echo json_encode($arr);
        }
        
        
        
        // $res_array=array();
        
        // $res=mysqli_fetch_assoc($query_run);
        // $res_array[]=$res;
        // $invo_id=$res['invo_no'];
        
        // $details=array();
        // $sel="SELECT * FROM billing_details WHERE bill_id='$invo_id'";
        // $msql_qry=mysqli_query($conn,$sel);
        
        // while($result=mysqli_fetch_assoc($msql_qry))
        // {
        //     $details[]=array(
        //                 "service"=>$result["service"],
        //                 "item"=>$result["item"],
        //                 "price"=>$result["price"],
        //                 "dis_rate"=>$result["dis_rate"],
        //                 "dis_amt"=>$result["dis_amt"],
        //                 "cgst_rate"=>$result["cgst_rate"],
        //                 "cgst_amt"=>$result["cgst_amt"],
        //                 "sgst_rate"=>$result["sgst_rate"],
        //                 "sgst_amt"=>$result["sgst_amt"],
        //                 "total"=>$result["total"],
        //                 "bill_id"=>$result["bill_id"],
        //         );
        // }
        //$array_marge=array_merge($res_array,$details);
        // $final_array[]=$res_array;
        // $final_array[]=$details;
        //  echo(json_encode($res_array,JSON_PRETTY_PRINT));
        //   echo(json_encode($details,JSON_PRETTY_PRINT));
        
        // if(mysqli_num_rows($query_run)>0){
        //     $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
        //     echo myResponseWithData(200,$res);
        // }else{
        //     echo myResponseNoData(204);
        // }
    }else{
        echo myResponseNoData(405);
    }
}


function SaveGalleryImage($input){
    global $conn;
    $path = mysqli_real_escape_string($conn,$input['path']);

    $query="INSERT INTO invoices (path) values ('$path')";
    $result=mysqli_query($conn,$query);

    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>