<?php
session_start();
include("api/config.php");

// print_r($_POST);
// exit;

if (!empty($_POST['email'])) {
    $username = $_POST['email'];
    
    function checkInputType($input) {
        $emailPattern = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
        $mobilePattern = "/^\+?\d{10,15}$/";
        if (preg_match($emailPattern, $input)) {
            return "Email";
        } elseif (preg_match($mobilePattern, $input)) {
            return "Mobile";
        } else {
            return "Invalid input";
        }
    }
    
    if(checkInputType($username)=="Mobile"){
        $check_dup = $obj->arr("SELECT email FROM users WHERE mobile='$username'");
        if (empty($check_dup)) {
            echo '<p class="alert alert-danger">User not found....!</p>';
            exit;
        }else{
            $username = $check_dup['email'];
        }
    }

    // Check if email exists in the database
    $check_dup = $obj->num("SELECT * FROM users WHERE email='$username'");

    if ($check_dup == 0) {
        echo '<p class="alert alert-danger">Email not found....!</p>';
        exit;
    }

    function generateRandomOTP($length1 = 4) 
    {
        $num = '0123456789';
        $otp_verify = '';
        $integerCount = strlen($num);
        for ($j = 0; $j < $length1; $j++) 
        {
            $otp_verify .= $num[rand(0, $integerCount - 1)];
        }
        return $otp_verify;
    }
    $randomOtp = generateRandomOTP(4);
    $to = $username;
    $subject = "Password Reset OTP";

    // Boundary 
    $boundary = md5(uniqid(time()));

    // Headers
    $headers = "From: MehndiPVC Support Team <info@mehndipvc.com>\r\n";
    $headers .= "Reply-To: info@mehndipvc.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n";

    // Plain text version
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "You are receiving this email because you requested to reset your password for your MehndiPVC account.\n\n";
    $body .= "To proceed with resetting your password, please use the following OTP: $randomOtp\n\n";
    $body .= "This OTP is valid for the next 15 minutes. If you did not request a password reset, please ignore this email.\n\n";
    $body .= "For any further assistance or inquiries, please contact our support team.\n\n";
    $body .= "Thank you for choosing MehndiPVC!\n";
    $body .= "Best Regards,\nMehndiPVC Support Team\r\n";
    
    // HTML version
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "<html><body>";
    $body .= "<p>Dear Customer,</p>";
    $body .= "<p>You are receiving this email because you requested to reset your password for your MehndiPVC account.</p>";
    $body .= "<p>To proceed with resetting your password, please use the following OTP:</p>";
    $body .= "<h2 style='color:green;'>$randomOtp</h2>";
    $body .= "<p>This OTP is valid for the next 15 minutes. If you did not request a password reset, please ignore this email.</p>";
    $body .= "<p>For any further assistance or inquiries, please contact our support team.</p>";
    $body .= "<p>Thank you for choosing MehndiPVC!</p>";
    $body .= "<p>Best Regards,<br>MehndiPVC Support Team</p>";
    $body .= "</body></html>\r\n";


    // End boundary
    $body .= "--$boundary--";

    // Send email
    $success = mail($to, $subject, $body, $headers);

    if ($success) {
        // Update user data with OTP
        $check = $obj->query("UPDATE `users` SET `otp`='$randomOtp', `is_reset`='No' WHERE email='$username'");

        if ($check) {
            $_SESSION["email"] = $username;
            echo 200;
        } else {
            echo '<p class="alert alert-danger">Error while updating data in the database....!!</p>';
        }
    } else {
        echo '<p class="alert alert-danger">Error while sending OTP....!!</p>';
    }
}
else
{
    echo '<p class="alert alert-danger">Please fill in the mandatory fields....!</p>';
}
?>
