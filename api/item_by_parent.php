<?php
include('dbcon.php');include('common_functions.php');

    $parent=$_POST['parent'];
    $userId=$_POST['user_id'];
    if(empty($parent)){
        echo myResponseNoData(405);
    }else{
       return getData($parent, $userId);
    }

 
function getData($parent, $userId){
    global $conn;
    // $getUserParentId = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = '$userId'");
    // $parentId = mysqli_fetch_assoc($getUserParentId)['parent'];
    // $query = "SELECT *,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = items.item_id AND discounts.user_id = $parentId) as discount FROM items where parent = $parent";
    
    $query = "SELECT *,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = items.item_id) as amount,(SELECT individual_price.set_price FROM individual_price WHERE individual_price.product_id = items.item_id && individual_price.user_id = $userId) as individual_discount FROM items where parent = $parent";
    $query_run = mysqli_query($conn,$query);
    if(mysqli_num_rows($query_run)>0){
        $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
        echo myResponseWithData(200,$res);
    }else{
        echo myResponseNoData(204);
    }
}
?>