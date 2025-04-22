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
    $query = "SELECT *,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = items.id) as discount FROM items";
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

function setData($input){
    global $conn;
    $item_id=mysqli_real_escape_string($conn,$input['item_id']);
    $name = mysqli_real_escape_string($conn,$input['name']);
    $code = mysqli_real_escape_string($conn,$input['code']);
    $image_url = mysqli_real_escape_string($conn,$input['image_url']);
    $parent = mysqli_real_escape_string($conn,$input['parent']);
    $price = mysqli_real_escape_string($conn,$input['price']);
    $quantity = mysqli_real_escape_string($conn,$input['quantity']);
    $about= mysqli_real_escape_string($conn,$input['about']);
    $features= mysqli_real_escape_string($conn,$input['features']);

    $query="INSERT INTO items(item_id,name,code,image_url,parent,price,quantity,about,features) 
    values ('$item_id','$name','$code','$image_url','$parent','$price','$quantity','$about','$features')";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>