<?php
include("dbcon.php");
$query = "SELECT *,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = items.id) as discount FROM items";
    $query_run = mysqli_query($conn,$query);
    if($query_run){
        if(mysqli_num_rows($query_run)>0){
            while($val=mysqli_fetch_assoc($query_run))
            {
                echo $val['id'];
                echo $val['item_id'];
                echo $val['cat_id'];
                echo $val['code'];
                echo $val['parent'];
                echo $val['price'];
                echo $val['quantity'];
                echo $val['about'];
                echo $val['features'];
                echo $val['status'];
                print json_encode(unserialize($val['image_url']));
            }
        }
    }

?>
