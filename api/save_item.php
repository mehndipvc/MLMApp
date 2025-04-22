<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod == "POST"){
   $input=json_decode(file_get_contents("php://input"),true);
   if (empty($input)){
       echo myResponseNoData(405);
   } else {
       return setData($input);
   }
} else {
   echo myResponseNoData(405);
}

function setData($input){
    global $conn;
    $parent_id = mysqli_real_escape_string($conn,$input['parent_id']);
    $item_id = mysqli_real_escape_string($conn,$input['item_id']);
    $price = mysqli_real_escape_string($conn,$input['price']);
    $status = mysqli_real_escape_string($conn,$input['status']);
    
    $query="UPDATE `items` SET `price`='$price',`status`='$status' WHERE `parent` = '$parent_id' AND `item_id` = '$item_id'";

    $result = mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>