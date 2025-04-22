<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');


    $status=$_POST['status'];
    $order_id=$_POST['order_id'];
    return updateData($order_id,$status);
 


 
 function updateData($order_id,$status){
    global $conn;
    $query = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(200);
    }else{
        echo myResponseNoData(400);
    }
}
