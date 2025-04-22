<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET"){
   return getData($_GET['user_id'], $_GET['for_user']);
} else if ($requestMethod == "POST"){
   $input = json_decode(file_get_contents("php://input"),true);
   if (empty($input)){
       echo myResponseNoData(405);
   } else {
       return setData($input);
   }
} else {
   echo myResponseNoData(405);
}

function getData($user, $for_user){
    global $conn;
    if ($user == "") {
        $query = "SELECT * FROM transaction_records where for_user = '$for_user' ORDER BY id DESC";
    } else {
        $query = "SELECT * FROM transaction_records where user_id = '$user' AND for_user = '$for_user' ORDER BY id DESC";
    }

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

function setData($input){
    global $conn;
    $user_id=mysqli_real_escape_string($conn,$input['user_id']);
    $for_user = mysqli_real_escape_string($conn,$input['for_user']);
    $type = mysqli_real_escape_string($conn,$input['type']);
    $amount = mysqli_real_escape_string($conn,$input['amount']);
    $note = mysqli_real_escape_string($conn,$input['note']);

    $query="INSERT INTO `transaction_records`(`user_id`, `for_user`, `type`, `amount`, `note`) VALUES ('$user_id','$for_user','$type','$amount','$note')";
    $result=mysqli_query($conn,$query);
    if ($result){        
        echo myResponseNoData(201);
    } else {
        echo myResponseNoData(400);
    }
}

?>