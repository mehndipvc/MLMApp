<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET"){
   return getData($_GET['startDate'], $_GET['endDate']);
} else {
   echo myResponseNoData(405);
}

function getData($startDate, $endDate){
    global $conn;
    if ($startDate == "") {
        $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name FROM `transaction_records` WHERE 1";
    } else {
        $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name FROM `transaction_records` WHERE `date` BETWEEN '$startDate' AND '$endDate' ORDER BY id DESC";
    }
    
    $query_run = mysqli_query($conn, $query);
    if($query_run) {
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            echo myResponseWithData(200,$res);
        } else {
            echo myResponseNoData(204);
        }
    } else {
        echo myResponseNoData(405);
    }
}

?>