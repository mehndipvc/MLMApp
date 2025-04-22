<?php
session_start();
include "header.php";
?>
<link href="https://unpkg.com/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<style>
body {
    background-color: #f4f7f6;
}
.page-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.rate-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    margin: 10px 0;
    background-color: #f4f4f4;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.rate-item:hover {
    background-color: #680658;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.rate-name {
    flex: 1;
    margin-left: 10px;
    font-size: 16px;
    font-weight: 500;
}

.rate-item i {
    font-size: 20px;
    color: #680658;
}

.rate-item:hover i {
    color: #fff;
}


</style>

<?php
$user_id = $_SESSION['user_id'];
$sel_user = $obj->arr("SELECT name,address,mobile,email FROM users WHERE user_id='$user_id'");
?>
<div class="container my-5">
    <div class="row">
        
        <div class="col-md-4">
            <div class="chart-container">
               
                <ul class="page-list">
                    <li class="rate-item" onclick="window.location.href='about-us.php'">
                        <i class="ri-information-line"></i>
                        <span class="rate-name">About Us</span>
                    </li>
                    <li class="rate-item" onclick="window.location.href='privacy-policy.php'">
                        <i class="ri-lock-line"></i>
                        <span class="rate-name">Privacy Policy</span>
                    </li>
                    <li class="rate-item" onclick="window.location.href='terms.php'">
                        <i class="ri-file-text-line"></i>
                        <span class="rate-name">Terms and Conditions</span>
                    </li>
                </ul>
            </div>
        </div>

        
        
    </div>
</div>


<?php include "footer.php" ?>
