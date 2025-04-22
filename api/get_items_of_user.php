<?php
include('dbcon.php');include('common_functions.php');

$category = $_GET['category'];
$user = $_GET['user_id'];

if (empty($category)){
    echo myResponseNoData(405);
} else {
    return getData($category, $user);
}
 
function getData($category, $user){
    global $conn;
    $getUserParentId = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = '$user'");
    $parentId = mysqli_fetch_assoc($getUserParentId)['parent'];

    $query = "SELECT *
            ,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = sub_users_items.item_id AND discounts.user_id = sub_users_items.user_id) as discount
            ,(SELECT items.name FROM items WHERE items.item_id = sub_users_items.item_id) AS name
            ,(SELECT items.code FROM items WHERE items.item_id = sub_users_items.item_id) AS code
            ,(SELECT items.image_url FROM items WHERE items.item_id = sub_users_items.item_id) AS image_url
            ,(SELECT items.parent FROM items WHERE items.item_id = sub_users_items.item_id) AS parent
            ,(SELECT items.price FROM items WHERE items.item_id = sub_users_items.item_id) AS item_price
            ,(SELECT items.quantity FROM items WHERE items.item_id = sub_users_items.item_id) AS quantity
            ,(SELECT items.about FROM items WHERE items.item_id = sub_users_items.item_id) AS about
            ,(SELECT items.features FROM items WHERE items.item_id = sub_users_items.item_id) AS features
            FROM `sub_users_items` WHERE `user_id` = '$parentId' AND `parent_id` = '$category';";

    $query_run = mysqli_query($conn,$query);
    if (mysqli_num_rows($query_run)>0){
        $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
        echo myResponseWithData(200,$res);
    } else {
        echo myResponseNoData(204);
    }
}
?>