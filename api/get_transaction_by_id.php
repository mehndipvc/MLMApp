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
} else {
   echo myResponseNoData(405);
}

function getData($user, $forUser){
    global $conn;
    if ($user == "") {
        if ($forUser == "") {
            $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name FROM transaction_records where 1 ORDER BY id DESC";
        } else {
            $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name FROM transaction_records where for_user = '$forUser' ORDER BY id DESC";
        }
    } else {
        if ($forUser == "") {
            $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name FROM transaction_records where user_id = '$user' ORDER BY id DESC";
        } else {
            $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name FROM transaction_records where user_id = '$user' AND for_user = '$forUser' ORDER BY id DESC";
        }
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
?>