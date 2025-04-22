<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');

 $requestMethod = $_SERVER["REQUEST_METHOD"];
 if($requestMethod == "GET"){
    $customerlist=getUserList();
    echo $customerlist;
 }else if($requestMethod == "POST"){
    $input=json_decode(file_get_contents("php://input"),true);
    return setUser($input);
 } 
 else{

    $data = [
        'status' => 405,
        'message' => $requestMethod. 'Method not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
 }


 function getUserList(){
    global $conn;
    $query = "SELECT users.user_id, users.name, users.email, users.mobile, COALESCE(SUM(orders.price), 0) AS total_orders_price, COALESCE(SUM(items.price), 0) AS total_items_price, COALESCE(SUM(orders.price), 0) + COALESCE(SUM(items.price), 0) AS total_price FROM users LEFT JOIN orders ON users.user_id = orders.user_id LEFT JOIN order_item ON orders.order_id = order_item.order_id LEFT JOIN items ON order_item.item_id = items.item_id WHERE 1 GROUP BY users.user_id, users.name, users.email, users.mobile; ";
    $query_run = mysqli_query($conn,$query);
    if($query_run){
        if(mysqli_num_rows($query_run)>0){
            $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'user list fetched successfully',
                'data' => $res,
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        }else{
            myresponse(404,'no user found','Method not allowed');  
        }
    }else{
        myresponse(500,'internal server error','Method not allowed');
    }
}

function myresponse($code,$msg){
    $data = [
        'status' => $code,
        'message' => $msg,
    ];
    header("HTTP/1.0".$code.$msg);
    return json_encode($data);
    exit();
}

function setUser($input){
    global $conn;
    $user_id = mysqli_real_escape_string($conn,$input['user_id']);
    $user_type = mysqli_real_escape_string($conn,$input['user_type']);
    $password = mysqli_real_escape_string($conn,$input['password']);
    $name = mysqli_real_escape_string($conn,$input['name']);
    $mobile = mysqli_real_escape_string($conn,$input['mobile']);
    $email = mysqli_real_escape_string($conn,$input['email']);
    $address = mysqli_real_escape_string($conn,$input['address']);
    $parent = mysqli_real_escape_string($conn,$input['parent']);



    if(empty(trim($name))){
        echo myResponseNoData(405);
    }else{
        $query="INSERT INTO users(user_id,user_type,password,name,parent,mobile,email,address) 
        values ('$user_id','$user_type','$password','$name','$parent','$mobile','$email','$address')";
        $result=mysqli_query($conn,$query);



        if($result){
            echo myResponseNoData(201);
        }else{
            echo myResponseNoData(400);
        }
    }
}



?>