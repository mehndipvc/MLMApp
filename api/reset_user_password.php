<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');

$phone = $_POST['phone'];
$password = $_POST['password'];
return updateUser($phone,$password);

function updateUser($phone,$password){
    global $conn;
    $checkUserExist = mysqli_query($conn, "SELECT * FROM `users` WHERE `mobile` = '$phone'");
    if (mysqli_num_rows($checkUserExist) > 0) {
        $query = "UPDATE users SET password='$password' WHERE mobile= '$phone'";
        $result = mysqli_query($conn,$query);
        if($result) {        
            echo myResponseNoData(200);
        } else {
            echo myResponseNoData(400);
        }
    } else {
        echo myResponseWithMessage(400, "No account found with this phone number");
    }
}
?>