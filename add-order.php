<?php

include('config.php');

if(!empty($_POST['user_id'])){
    $user_id=$_POST['user_id'];
    $sel_cart=$obj->fetch("SELECT * FROM cart_item WHERE user_id='$user_id'");
    
    $total_price=0;
    
    $pro_ids=[];
    $pro_names=[];
    $pro_qty=[];
    $order_id=rand(0000000000000,9999999999999);
    $user_name=$_POST['userName'];
    
    foreach($sel_cart as $val_cart){
        $amt=$val_cart['quantity']*$val_cart['price'];
        $total_price+=$amt;
        $pro_ids[]=$val_cart['item_id'];
        $pro_names[]=$val_cart['name'];
        $pro_qty[]=$val_cart['quantity'];
        
        $pro_id=$val_cart['item_id'];
        $name=$val_cart['name'];
        $code=$val_cart['code'];
        $image_url=$val_cart['image_url'];
        $price=$val_cart['price'];
        $quantity=$val_cart['quantity'];
        
        $ins_item=$obj->query("INSERT INTO order_item(item_id,name,code,image_url,parent,price,quantity,about,features,user_id,actual_price,total_price,order_id) 
        values ('$pro_id','$name','$code','$image_url','','$price','$quantity','','','$user_id','$price','$amt','$order_id')");
        
    }
    
    $pro_ids=implode(',',$pro_ids);
    $pro_names=implode(',',$pro_names);
    $pro_qty=implode(',',$pro_qty);
    
    date_default_timezone_set('Asia/Kolkata');
    $current_time = date("h:i:s A");
    $date=date('Y-d-m');
    
    $query_ins=$obj->query("INSERT INTO orders(price,user_id,order_id,date,status,title,name,product_id,order_quantity,time,type) 
    values ('$total_price','$user_id','$order_id','$date','Pending Confirmation','$pro_names','$user_name','$pro_ids','$pro_qty','$current_time','Automatic')");
    
    $del_cart=$obj->query("DELETE FROM cart_item WHERE user_id='$user_id'");
    
    if($query_ins){
        echo 200;
    }else{
         echo '<p class="alert alert-warning">Error while submit</p>';
    }
    

}else{
    echo '<p class="alert alert-warning">User id is empty</p>';
}

?>