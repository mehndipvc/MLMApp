<?php
include("../mehndi/config.php");
$fetch=$obj->fetch("SELECT * FROM gal_category");
print json_encode($fetch);
?>