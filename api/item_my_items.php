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
    $query = "SELECT *
    ,(SELECT items.name FROM items WHERE items.item_id = discounts.item_id) AS name
    ,(SELECT items.code FROM items WHERE items.item_id = discounts.item_id) AS code 
    ,(SELECT items.image_url FROM items WHERE items.item_id = discounts.item_id) AS image_url 
    ,(SELECT items.parent FROM items WHERE items.item_id = discounts.item_id) AS parent 
    ,(SELECT items.price FROM items WHERE items.item_id = discounts.item_id) AS price 
    ,(SELECT items.quantity FROM items WHERE items.item_id = discounts.item_id) AS quantity 
    ,(SELECT items.about FROM items WHERE items.item_id = discounts.item_id) AS about 
    ,(SELECT items.features FROM items WHERE items.item_id = discounts.item_id) AS features FROM `discounts` WHERE `user_id` = '$userId'";
    
    $query_run = mysqli_query($conn,$query);
    
    $jsonArray = array();
    while ($row = mysqli_fetch_assoc($query_run)) {
        if ($row['parent'] == $parent) {
            $jsonArray[] = $row;
        }
    }

    if (mysqli_num_rows($query_run) > 0){
        echo myResponseWithData(200, $jsonArray);
    } else {
        echo myResponseNoData(204);
    }
}
?>