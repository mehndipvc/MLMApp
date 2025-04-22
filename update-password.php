<?php

include('config.php');

if(!empty($_POST['user_id']) && !empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
    
    $user_id=$_POST['user_id'];
    $old_password=$_POST['old_password'];
    $new_password=$_POST['new_password'];
    $confirm_password=$_POST['confirm_password'];
    
    if($new_password!=$confirm_password){
        echo '<p class="alert alert-warning">Password and confirm password is not matching</p>';
        exit;
    }
    
    $check_pass=$obj->num("SELECT id FROM users WHERE user_id='$user_id' AND password='$old_password'");
    
    if($check_pass==0){
        echo '<p class="alert alert-warning">Current password is invalid</p>';
        exit;
    }
    
    $query_ins=$obj->query("UPDATE users SET password='$confirm_password' WHERE user_id='$user_id'");

    
    if($query_ins){
        echo 200;
    }else{
         echo '<p class="alert alert-warning">Error while submit</p>';
    }
    

}else{
    echo '<p class="alert alert-warning">Please fillup mendatory fields</p>';
}

?>