<?php
// $host="localhost";
// $username="u439213217_mehndi_pro23";
// $password="Mehndi@2023$#";
// $dbname="u439213217_mehndi_pro";
$host="localhost";
$username="mehndipvc_u439213217_mehndi_pro2";
$password="Mehndi@2023$#";
$dbname="mehndipvc_u439213217_mehndi_pro";

$conn=mysqli_connect($host,$username,$password,$dbname);
if(!$conn){
    die("connection failed: ". mysqli_connect_error());
}
// else{
//     echo "connection successfull";
// }
?>