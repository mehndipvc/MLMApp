<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');

$input=json_decode(file_get_contents("php://input"),true);
return updateUser($input);



function updateUser($input){
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
        $query="UPDATE users SET user_type='$user_type', password='$password', name='$name', parent='$parent', mobile='$mobile', email='$email', address='$address'
                WHERE user_id= $user_id";
        $result=mysqli_query($conn,$query);

        if($result){
            echo myResponseNoData(201);
        }else{
            echo myResponseNoData(400);
        }
    }
}



?>