<?php
session_start();
include("api/config.php");

if(!empty($_POST['email']) && !empty($_POST['otp']))
{
    $username=$_POST['email'];
    $otp=$_POST['otp'];
    
    $check_dup=$obj->num("SELECT * FROM users WHERE email='$username' OR mobile='$username'");
    
    if($check_dup==0){
        echo '<p class="alert alert-danger"> Email not found....!</p>';
        exit;
    }
    
    $check_otp=$obj->num("SELECT * FROM users WHERE (email='$username' OR mobile='$username') AND otp='$otp'");
   
    if ($check_otp>0) {

        $check = $obj->query("UPDATE `users` SET is_reset='Yes',otp='0' WHERE email='$username' OR mobile='$username'");

        echo 200;
    } else {
        echo '<p class="alert alert-danger"> Invalid OTP....!!</p>';
    }
}
else
{
    echo '<p class="alert alert-danger"> Please Fillup Mendatory Fields....!</p>';
}
?>
