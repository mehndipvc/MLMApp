<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
 header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include('dbcon.php');
include('common_functions.php');


 $requestMethod = $_SERVER["REQUEST_METHOD"];
 if($requestMethod == "GET"){
    return getData();
 } else if ($requestMethod == "POST"){
    $input=json_decode(file_get_contents("php://input"),true);
    if (empty($input)){
        echo myResponseNoData(405);
    } else {
        return setData($input);
    }
 } else {
    echo myResponseNoData(405);
 }


 function getData(){
    global $conn;
    $query = "SELECT * FROM category";
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




?>