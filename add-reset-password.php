<?php
session_start();
include("api/config.php");

if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['cpassword']))
{
    $username=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    
    if($password!=$cpassword){
        echo '<p class="alert alert-danger"> Password and confirm password is not matching....!</p>';
        exit;
    }
    
    $check_dup=$obj->num("SELECT * FROM users WHERE email='$username' OR mobile='$username'");
    
    if($check_dup==0){
        echo '<p class="alert alert-danger"> Email not found....!</p>';
        exit;
    }
    
    $check_otp=$obj->num("SELECT * FROM users WHERE (email='$username' OR mobile='$username') AND is_reset='Yes'");
   
    if ($check_otp>0) {

        $check = $obj->query("UPDATE `users` SET is_reset='No',password='$password' WHERE email='$username' OR mobile='$username'");

        echo 200;
    } else {
        echo '<p class="alert alert-danger"> Invalid Request...!!</p>';
    }
}
else
{
    echo '<p class="alert alert-danger"> Please Fillup Mendatory Fields....!</p>';
}
?>
