<?php

include('config.php');

if(!empty($_POST['user_id']) && !empty($_POST['mobile']) && !empty($_POST['name']) && !empty($_POST['email'])){
    
    $user_id=$_POST['user_id'];
    $mobile=$_POST['mobile'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    
    $query_ins=$obj->query("UPDATE users SET name='$name', mobile='$mobile', email='$email', address='$address'
    WHERE user_id='$user_id'");

    
    if($query_ins){
        echo 200;
    }else{
         echo '<p class="alert alert-warning">Error while submit</p>';
    }
    

}else{
    echo '<p class="alert alert-warning">User id is empty</p>';
}

?>