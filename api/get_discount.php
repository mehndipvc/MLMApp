<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');


$requestMethod = $_SERVER["REQUEST_METHOD"];
    $user_id=$_POST['user_id'];
    $item_id=$_POST['item_id'];
    return getData($user_id,$item_id);

function getData($user_id,$item_id){
    global $conn;
    $getUserParentId = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = '$user_id'");
    $parentId = mysqli_fetch_assoc($getUserParentId)['parent'];
    
    $query = "SELECT * FROM discounts where  user_id='$parentId' AND item_id='$item_id'";
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