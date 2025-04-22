<?php
include('dbcon.php');include('common_functions.php');

    $item_id=$_POST['item_id'];
    if(empty($item_id)){
        echo myResponseNoData(405);
    }else{
        return getImageList($item_id);
    }

 
function getImageList($item_id){
    global $conn;
    $query = "SELECT filename FROM items_images where item_id = $item_id ";
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
?>