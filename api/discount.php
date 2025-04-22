<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');

   $input=json_decode(file_get_contents("php://input"),true);
   return setData($input);


function setData($input){
    global $conn;
    $item_id=mysqli_real_escape_string($conn,$input['item_id']);
    $user_id = mysqli_real_escape_string($conn,$input['user_id']);
    $discount_type = mysqli_real_escape_string($conn,$input['discount_type']);
    $amount = mysqli_real_escape_string($conn,$input['amount']);
    
    $checkCopuonExist = "SELECT * FROM discounts where  user_id=$user_id AND item_id=$item_id ";
    $checkCopuonExistRun = mysqli_query($conn, $checkCopuonExist);
    if (mysqli_num_rows($checkCopuonExistRun) > 0) {
        $query="UPDATE `discounts` SET `discount_type`='$discount_type',`amount`='$amount' WHERE `user_id` = $user_id AND `item_id` = $item_id";
    } else {
        $query="INSERT INTO discounts(user_id,item_id,discount_type,amount) values ('$user_id','$item_id','$discount_type','$amount')";
    }
    
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>