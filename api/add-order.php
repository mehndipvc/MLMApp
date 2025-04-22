<?php
 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('config.php');

if(!empty($_POST['user_id'])){
    $user_id=$_POST['user_id'];
    $sel_cart=$obj->fetch("SELECT * FROM cart_item WHERE user_id='$user_id'");
    
    $total_price=0;
    
    $pro_ids=[];
    $pro_names=[];
    $pro_qty=[];
    $order_id=rand(0000000000000,9999999999999);
    $user_name=$_POST['name'];
    
    foreach($sel_cart as $val_cart){
        $total_price+=$val_cart['total_price'];
        $pro_ids[]=$val_cart['item_id'];
        $pro_names[]=$val_cart['name'];
        $pro_qty[]=$val_cart['quantity'];
    }
    
    $pro_ids=implode(',',$pro_ids);
    $pro_names=implode(',',$pro_names);
    $pro_qty=implode(',',$pro_qty);
    
    date_default_timezone_set('Asia/Kolkata');
    $current_time = date("h:i:s A");
    $date=date('d-m-Y');
    
    $query_ins=$obj->query("INSERT INTO orders(price,user_id,order_id,date,status,title,name,product_id,order_quantity,time) 
    values ('$total_price','$user_id','$order_id','$date','Pending Confirmation','$pro_names','$user_name','$pro_ids','$pro_qty','$current_time')");
    
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