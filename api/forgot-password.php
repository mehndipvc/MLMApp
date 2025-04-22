<?php
include("config.php");
if(!empty($_POST['email']) && !empty($_POST['password']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];
    $check=$obj->num("SELECT id FROM users WHERE email='$email'");
    if($check==1)
    {
        $update=$obj->query("UPDATE users SET password='$password' WHERE email='$email'");
        if($update)
        {
            $data=array(
                'msg'=>'Password Updated Successfully',
                );
            echo json_encode($data);
        }
    }
    else
    {
        $data=array(
                'msg'=>'User not found',
                );
        echo json_encode($data);
    }
}
else
{
    $data=array(
        'msg'=>'Invalid Parameter',
    );
    echo json_encode($data);
}
?>