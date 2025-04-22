<?php
include('config.php');

if(!empty($_POST['user_id'])){
    $user_id=$_POST['user_id'];
    $sel_order=$obj->fetch("SELECT * FROM orders WHERE user_id='$user_id'");
    echo json_encode($sel_order);
}

?>