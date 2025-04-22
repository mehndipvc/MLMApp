<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');


$user_id=$_POST['user_id'];
$password=$_POST['password'];
return updateUser($user_id,$password);



function updateUser($user_id,$password){
    global $conn;

    $query="UPDATE users SET password=$password WHERE user_id= $user_id";
    $result=mysqli_query($conn,$query);
    if($result){        
        echo myResponseNoData(200);
    }else{
        echo myResponseNoData(400);
    }
}




?>