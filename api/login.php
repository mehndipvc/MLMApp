<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Cache-Control: no-store, no-cache, must-revalidate');

include('dbcon.php');
session_start();

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    echo json_encode(loginUser($input));
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

function loginUser($input) {
    global $conn;
    
    $mobile = mysqli_real_escape_string($conn, trim($input['mobile']));
    $password = mysqli_real_escape_string($conn, trim($input['password']));
    
    if(empty($mobile) || empty($password)) {
        return ['status' => 400, 'message' => 'All fields are required.'];
    }
    
    $query = "SELECT * FROM users WHERE mobile = '$mobile'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($password==$user['password'] && $mobile==$user['mobile']) {
            $_SESSION['mobile'] = $mobile;
            return ['status' => 200, 'message' => 'Login Successful'];
        } else {
            return ['status' => 401, 'message' => 'Invalid Email or Password'];
        }
    } else {
        error_log(mysqli_error($conn));
        return ['status' => 500, 'message' => 'Internal Server Error'];
    }
}
?>