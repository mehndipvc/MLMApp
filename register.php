<?php

include('config.php');

function validateMobileNumber($number) {

    $pattern = '/^\d{10}$/';

    if (preg_match($pattern, $number)) {
        return true;
    } else {
        return false;
    }
}


if(!empty($_POST['name']) && !empty($_POST['mobile']) && !empty($_POST['email']) && !empty($_POST['address'])  && !empty($_POST['password'])){
    
    $name=$_POST['name'];
    $mobile=$_POST['mobile'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $password=$_POST['password'];
    
    if (!validateMobileNumber($mobile)) {
        echo '<p class="alert alert-warning">Invalid Mobile No.</p>';
        exit;
    } 
    
    $dup_check=$obj->num("SELECT user_id FROM users WHERE name='$name' OR mobile='$mobile' OR email='$email'");
    
    if ($dup_check>0) {
        echo '<p class="alert alert-warning">Duplicate Records Found</p>';
        exit;
    } 

    $sel_last=$obj->arr("SELECT user_id FROM users ORDER BY id DESC");
    $user_id=$sel_last['user_id']+1;
    
    $ins_item=$obj->query("INSERT INTO users(user_id,user_type,password,name,parent,mobile,email,address) 
    values ('$user_id','Customer','$password','$name','$parent','$mobile','$email','$address')");
    
    if($ins_item){
        echo 200;
    }else{
         echo '<p class="alert alert-warning">Error while submit</p>';
    }
    

}else{
    echo '<p class="alert alert-warning">Please fillup mendatory fields</p>';
}

?>