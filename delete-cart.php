<?php


$user_id=$_COOKIE['user_id'];

include('config.php');

if (!empty($_POST['pro_id'])) {
    $pro_id = $_POST['pro_id'];

    // Check if the item exists in the cart
    $num = $obj->num("SELECT id FROM cart_item WHERE item_id='$pro_id' AND user_id='$user_id'");
    if ($num > 0) {
        // Delete the item from the cart
        $delete = $obj->query("DELETE FROM cart_item WHERE item_id='$pro_id' AND user_id='$user_id'");
        if ($delete) {
            
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
            
        } else {
            $data=array(
                "status"=>500,"msg"=>'<p class="alert alert-danger">Failed to remove item from cart</p>'
            );
            echo json_encode($data);
        }
    } else {
        $data=array(
            "status"=>500,"msg"=>'<p class="alert alert-danger">Item not found in cart</p>'
        );
        echo json_encode($data);
    }
} else {
    $data=array(
        "status"=>500,"msg"=>'<p class="alert alert-danger">Invalid request</p>'
    );
    echo json_encode($data);
}
?>
