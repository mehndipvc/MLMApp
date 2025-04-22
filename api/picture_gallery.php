<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');
include('common_functions.php');


 $requestMethod = $_SERVER["REQUEST_METHOD"];
 if($requestMethod == "GET"){
    return getData($_GET['cat_id']);
 }else if($requestMethod == "POST"){
    $input=json_decode(file_get_contents("php://input"),true);
    if(empty($input)){
        echo myResponseNoData(405);
    }else{
        return SaveGalleryImage($input);
    }
 }else{
    echo myResponseNoData(405);
 }


 function getData($cat_id){
    global $conn;
    $query = "SELECT * FROM items_images WHERE cat_id='$cat_id' AND status = 'Approve' ORDER BY id DESC";
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


function SaveGalleryImage($input){
    global $conn;
    $user_id = mysqli_real_escape_string($conn,$input['user_id']);
    $cat_id=mysqli_real_escape_string($conn,$input['cat_id']);
    $query="INSERT INTO picture_gallery(user_id,cat_id)  values ('$user_id','$cat_id')";
    echo $query;
    $result=mysqli_query($conn,$query);

    if($result){        
        echo myResponseNoData(200);
    }else{
        echo myResponseNoData(400);
    }
}



?>