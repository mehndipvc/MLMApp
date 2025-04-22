<?php
include("config.php");
if(!empty($_POST['email']))
{
    $email=$_POST['email'];
    $check=$obj->num("SELECT email FROM users WHERE email='$email'");
    if($check==1)
    {
        $otp=rand(0000,9999);
         $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From:info@mehndipvc.shop'."\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
        
        //replace with your email
        $email_to = $email;
        $subject = "OTP Verification for Forgot Password";
        
        $body="Dear Customer, <br><br>
        Please use this OTP <b><span style='color:blue'>$otp</span></b> to complete Forgot Password process.<br><br>
       <br><br> 
        Thanks & Regards,<br><br>
        Mehndi Profile ";
        
        $success = mail($email_to, $subject, $body, $headers);
        if($success)
        {
            $data=array(
                'status'=>'success',
                'otp'=>$otp
                );
           echo json_encode($data);
        }
        else
        {
           echo 'Failed something wrong';
        }
    }
    else
    {
        echo 'User not found';
    }
}
else
{
    echo 'Invalid Parameter';
}
?>