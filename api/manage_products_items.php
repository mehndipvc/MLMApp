<?php
include('dbcon.php');include('common_functions.php');

$parent=$_GET['parent'];
$userId=$_GET['user_id'];
if (empty($parent)){
    echo myResponseNoData(405);
} else {
   return getData($parent, $userId);
}

function getData($parent, $userId){
    global $conn;
    $query = "SELECT *,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = items.item_id AND discounts.user_id = $userId) as discount,(SELECT sub_users_items.price FROM sub_users_items WHERE sub_users_items.user_id = $userId AND sub_users_items.item_id = items.item_id) AS user_set_price,(SELECT sub_users_items.status FROM sub_users_items WHERE sub_users_items.user_id = $userId AND sub_users_items.item_id = items.item_id) AS user_set_status FROM items where parent = $parent";

    $query_run = mysqli_query($conn,$query);
    if (mysqli_num_rows($query_run) > 0){
        $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
        echo myResponseWithData(200,$res);
    } else {
        echo myResponseNoData(204);
    }
}
?>