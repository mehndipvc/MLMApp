<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');


$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET"){
   return getData($_GET['startDate'], $_GET['endDate'], $_GET['userId']);
}else if($requestMethod == "POST"){
   $input=json_decode(file_get_contents("php://input"),true);
   if(empty($input)){
       echo myResponseNoData(405);
   }else{
       return setData($input);
   }
}else{
   echo myResponseNoData(405);
}

function getData($startDate, $endDate, $user){
   global $conn;
   if ($startDate == "") {
       if ($user == "") {
           $query = "SELECT * FROM orders ";
             
       } else {
           $query = "SELECT * FROM orders WHERE user_id = '$user'";
            // echo 'd';
            //     exit;
       }
   } else {
        if ($user == "") {
            $query = "SELECT * FROM orders WHERE `date`  BETWEEN '$startDate' AND '$endDate'";
        } else {
            $query = "SELECT * FROM orders WHERE user_id = '$user' AND date BETWEEN '$startDate' AND '$endDate'";
        }
   }
   
   $query_run = mysqli_query($conn,$query);
   if($query_run){
       if(mysqli_num_rows($query_run)>0){
           $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
           
           echo myResponseWithData(200,$res);
          
       }else{
           echo myResponseNoData(204);
       }
   }else{
       echo myResponseNoData(405);
   }
}

function setData($input){
    global $conn;
    $order_quantity = mysqli_real_escape_string($conn,$input['order_quantity']);
    $price = mysqli_real_escape_string($conn,$input['price']);
    $user_id= mysqli_real_escape_string($conn,$input['user_id']);
    $order_id= mysqli_real_escape_string($conn,$input['order_id']);
    
    $date= mysqli_real_escape_string($conn,$input['date']);
    
    date_default_timezone_set('Asia/Kolkata');
    $current_time = date("h:i:s A");
    
    $status= mysqli_real_escape_string($conn,$input['status']);
    $title= mysqli_real_escape_string($conn,$input['title']);
    $name= mysqli_real_escape_string($conn,$input['name']);
    $product_id= mysqli_real_escape_string($conn,$input['product_id']);

    $query="INSERT INTO orders(price,user_id,order_id,date,status,title,name,product_id,order_quantity,time) 
    values ('$price','$user_id','$order_id','$date','$status','$title','$name','$product_id','$order_quantity','$current_time')";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>