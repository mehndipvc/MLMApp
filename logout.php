<?php
setcookie('id', '', time() - 3600, "/"); // Expire the 'id' cookie
setcookie('user_id', '', time() - 3600, "/"); // Expire the 'user_id' cookie
setcookie('user_type', '', time() - 3600, "/"); // Expire the 'user_type' cookie
setcookie('mobile', '', time() - 3600, "/"); // Expire the 'mobile' cookie

header("location:https://app.pvcinterior.in/login.php");
exit;

?>