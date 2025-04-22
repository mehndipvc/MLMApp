<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');

$item_id=$_POST['item_id'];
$user_id=$_POST['user_id'];
$quantity=$_POST['quantity'];
$total_price=$_POST['total_price'];
return updateData($item_id,$user_id,$quantity,$total_price);


function updateData($item_id,$user_id,$quantity,$total_price){
    global $conn;

    
    $query="UPDATE cart_item SET quantity=$quantity, total_price=$total_price WHERE item_id=$item_id AND user_id=$user_id ";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(200);
    }else{
        echo myResponseNoData(400);
    }
}



?>