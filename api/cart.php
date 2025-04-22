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
    $name = mysqli_real_escape_string($conn,$input['name']);
    $code = mysqli_real_escape_string($conn,$input['code']);
    $image_url = mysqli_real_escape_string($conn,$input['image_url']);
    $parent = mysqli_real_escape_string($conn,$input['parent']);
    $price = mysqli_real_escape_string($conn,$input['price']);
    $quantity = mysqli_real_escape_string($conn,$input['quantity']);
    $about= mysqli_real_escape_string($conn,$input['about']);
    $features= mysqli_real_escape_string($conn,$input['features']);
    $user_id= mysqli_real_escape_string($conn,$input['user_id']);
    $actual_price= mysqli_real_escape_string($conn,$input['actual_price']);
    $total_price= mysqli_real_escape_string($conn,$input['total_price']);

    $query="INSERT INTO cart_item(item_id,name,code,image_url,parent,price,quantity,about,features,user_id,actual_price,total_price) 
    values ('$item_id','$name','$code','$image_url','$parent','$price','$quantity','$about','$features','$user_id','$actual_price','$total_price')";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(201);
    }else{
        echo myResponseNoData(400);
    }
}



?>