<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET"){
   return getData($_GET['user_id']);
} else {
   echo myResponseNoData(405);
}

function getData($user){
    global $conn;
    $query = "SELECT * FROM `users` WHERE user_id = $user";
    $query_run = mysqli_query($conn, $query);
    if($query_run) {
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            echo myResponseWithData(200,$res);
        }else{
            echo myResponseNoData(204);
        }
    } else {
        echo myResponseNoData(405);
    }
}
?>