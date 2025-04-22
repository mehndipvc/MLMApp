<?php

session_start();
$user_id=$_COOKIE['user_id'];

include('config.php');
if(!empty($_POST['pro_id']) && !empty($_POST['price'])){
    
    $pro_id=$_POST['pro_id'];
    $price=$_POST['price'];
    $image_url=$_POST['image_url'];
    
    $sel_product=$obj->arr("SELECT code,name FROM items WHERE id='$pro_id'");
    
    $item_id=$sel_product['code'];
    $name=$sel_product['name'];
    $quantity=1;
    
    $sel_cart=$obj->arr("SELECT quantity FROM cart_item WHERE item_id='$pro_id' AND user_id='$user_id'");
    
    if(!empty($sel_cart)){
        $quantity=$sel_cart['quantity']+1;
        $ins_cart=$obj->query("UPDATE cart_item SET quantity='$quantity',price='$price' WHERE item_id='$pro_id' AND user_id='$user_id' ");
    }else{
        $ins_cart=$obj->query("INSERT INTO cart_item(item_id,name,code,image_url,price,quantity,about,features,user_id,actual_price,total_price,parent) 
        values ('$pro_id','$name','$code','$image_url','$price','$quantity','','','$user_id','','','')");
    }
    
    if($ins_cart){
        echo 200;
    }else{
       echo '<p>Error while adding to cart</p>'; 
    }
    
    
}else{
    echo '<p>Please fillup mendatory fields</p>';
}



?>