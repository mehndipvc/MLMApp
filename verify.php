<?php
session_start();
include('config.php');

$response = array();

if(!empty($_POST['mobile']) && !empty($_POST['password'])){
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    
    function isValidMobile($number) {
        $pattern = "/^[6-9]\d{9}$/";
        return preg_match($pattern, $number) === 1;
    }
    
    if (isValidMobile($mobile)) {
        $check_user = $obj->arr("SELECT user_id,id,user_type FROM users WHERE mobile='$mobile' AND password='$password'");
    } else {
        $check_user = $obj->arr("SELECT user_id,id,user_type FROM users WHERE email='$mobile' AND password='$password'");
    }
    
    if(!empty($check_user)){
        // $_SESSION['id'] = $check_user['id'];
        // $_SESSION['user_id'] = $check_user['user_id'];
        // $_SESSION['user_type'] = $check_user['user_type'];
        // $_SESSION['mobile'] = $mobile;
        setcookie('id', $check_user['id'], time() + (86400 * 30), "/"); // 30 days
        setcookie('user_id', $check_user['user_id'], time() + (86400 * 30), "/");
        setcookie('user_type', $check_user['user_type'], time() + (86400 * 30), "/");
        setcookie('mobile', $mobile, time() + (86400 * 30), "/");

        
        $response['status'] = 'success';
        $response['redirect'] = 'index.php';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid mobile or password';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Please fill up mandatory fields';
}

echo json_encode($response);
?>
