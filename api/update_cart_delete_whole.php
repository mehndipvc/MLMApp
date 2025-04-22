<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');

$item_id=$_POST['item_id'];
return updateData($user_id);


function updateData($user_id){
    global $conn;

    
    $query="DELETE FROM cart_item WHERE user_id=$user_id ";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(200);
    }else{
        echo myResponseNoData(400);
    }
}



?>