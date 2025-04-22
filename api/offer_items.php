<?php
include('dbcon.php');include('common_functions.php');

  

    // $query = "SELECT *,(SELECT discounts.discount_type FROM discounts WHERE discounts.item_id = items.item_id) AS discount,(SELECT discounts.amount FROM discounts WHERE discounts.item_id = items.item_id) AS amount FROM `items` WHERE `parent` = '$parent'";
    $query = "SELECT * FROM `discounts` ORDER BY id DESC";
    $query_run = mysqli_query($conn,$query);
    
    $jsonArray = array();
    while ($row = mysqli_fetch_assoc($query_run)) {
        $item_id=$row['item_id'];
        $sel=mysqli_query($conn,"SELECT * FROM items WHERE id='$item_id'");
        $data_fetch=mysqli_fetch_assoc($sel);
        if($data_fetch['discount_type']=='Percentage')
        {
            $discount_price=(($data_fetch['price']/100)*$row['amount'])+$data_fetch['price'];
        }
        else
        {
            $discount_price=$data_fetch['price']-$row['amount'];
        }
       $json_decode=json_decode($data_fetch['image_url']); 
       $remove_dot=str_replace('../api/assets/', '',$json_decode[0]->image);
        $jsonArray[] = array(
                "item_name"=>$data_fetch['name'],
                "price"=>$data_fetch['price'],
                "discount_price"=>$discount_price,
                "product_image"=>$remove_dot,
            );
    }

    print(json_encode($jsonArray,JSON_PRETTY_PRINT));

?>