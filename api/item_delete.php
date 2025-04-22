<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');


$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "POST"){
    $input = json_decode(file_get_contents("php://input"), true);
    if(empty($input)){
        echo myResponseNoData(405);
    }else{
        return setData($input);
    }
} else {
    echo myResponseNoData(405);
}

function setData($input){
    global $conn;
    $item_id = mysqli_real_escape_string($conn, $input['item_id']);

    $query = "DELETE FROM `items` WHERE `item_id` = '$item_id'";
    $query2 = "DELETE FROM `items` WHERE `parent` = '$item_id'";
    mysqli_query($conn, $query2);

    $result = mysqli_query($conn, $query);
    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>