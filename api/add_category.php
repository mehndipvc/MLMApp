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
    $item_id=mysqli_real_escape_string($conn,$input['item_id']);
    $name = mysqli_real_escape_string($conn,$input['name']);
    $image_url = mysqli_real_escape_string($conn,$input['image_url']);
    $parent = mysqli_real_escape_string($conn,$input['parent']);

    $query = "INSERT INTO `items`(`item_id`, `name`,  `image_url`, `parent`) VALUES ('$item_id','$name','$image_url','$parent')";
    $result = mysqli_query($conn,$query);
    if ($result) {
        echo myResponseNoData(201);
    } else {
        echo myResponseNoData(400);
    }
}



?>