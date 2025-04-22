<?php
include("config.php");

// if(isset($_GET['user_id'])) {
//     $user_id = $_GET['user_id'];

//     $fetch = $obj->fetch("SELECT * FROM rate_chart WHERE user_id='$user_id' OR user_id='All User'");
//     $data = array();
//     $data=$fetch;
//     print_r(json_encode($data, JSON_PRETTY_PRINT));
// }

    $fetch = $obj->fetch("SELECT * FROM rate_chart");
    $data = array();
    $data=$fetch;
    print_r(json_encode($data, JSON_PRETTY_PRINT));

?>
