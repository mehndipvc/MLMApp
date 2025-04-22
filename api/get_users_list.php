<?php
include('dbcon.php');
include('common_functions.php');

$parent = "";
if (isset($_POST['parent'])) {
   $parent = $_POST['parent']; 
}

$userType = $_POST['user_type'];

if(empty($userType)){
    echo myResponseNoData(405);
} else {
   return getData($parent, $userType);
}

function getData($parent, $userType){
    global $conn;
    if (!empty($parent)) {
        $query = "SELECT * FROM `users` WHERE `user_type` = '$userType' AND `parent` = '$parent'";
    } else {
        $query = "SELECT * FROM `users` WHERE `user_type` = '$userType'";    
    }
    
    $query_run = mysqli_query($conn, $query);
    if ($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            echo myResponseWithData(200,$res);
        }else{
            echo myResponseNoData(204);
        }
    } else {
        echo myResponseNoData(405);
    }
}
?>