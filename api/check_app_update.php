<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET"){
   return getData();
} else {
   echo myResponseNoData(405);
}

function getData(){
    global $conn;
    $query = "SELECT * FROM `app_update` WHERE 1 LIMIT 1";
    $query_run = mysqli_query($conn, $query);
    if($query_run) {
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_assoc($query_run);
            echo myResponseWithData(200,$res);
        }else{
            echo myResponseNoData(204);
        }
    } else {
        echo myResponseNoData(405);
    }
}
?>