<?php

$user_id=$_COOKIE['user_id'];

include('config.php');
if(!empty($_POST['pro_id']) && !empty($_POST['qty'])){
    $pro_id=$_POST['pro_id'];
    $qty=$_POST['qty'];
    
    $num=$obj->num("SELECT id FROM cart_item WHERE item_id='$pro_id' AND user_id='$user_id'");
    if($num!=0)
    {
        $update=$obj->query("UPDATE cart_item SET quantity='$qty' WHERE item_id='$pro_id' AND user_id='$user_id'");
    }
    else
    {
        $update=$obj->query("UPDATE cart_item SET quantity='$qty' WHERE item_id='$pro_id' AND user_id='$user_id'");
    }
    if($update)
    {
        $sel_cart=$obj->fetch("SELECT price,quantity FROM cart_item WHERE user_id='$user_id'");
        $total_amt=0;
        foreach($sel_cart as $val){
            $amt=$val['price']*$val['quantity'];
            $total_amt+=$amt;
        }
        
        $data=array(
            "status"=>200,"amount"=>$total_amt
        );
        echo json_encode($data);
    }
    else
    {
        $data=array(
            "status"=>500,"msg"=>'<p class="alert alert-danger">Cart updated failed</p>'
        );
        echo json_encode($data);
    }
}
else
{
    $data=array(
        "status"=>500,"msg"=>'<p class="alert alert-danger">Error something wrong</p>'
    );
    echo json_encode($data);
}
?>