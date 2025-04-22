<?php
session_start();
if(!isset($_COOKIE['mobile']))
{
    echo '<script>window.location.href="login.php"</script>';
}
include("config.php");
$user_id=$_COOKIE['user_id'];
$check_user = $obj->arr("SELECT user_type FROM users WHERE user_id='$user_id'");
$_COOKIE['user_type'] = $check_user['user_type'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mehndi PVC</title>
        <!-- Owl Carousel CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <style>
        .col{
            cursor:pointer;
        }
        .col {
            max-width: 145px;
            max-height: 145px;
        }
        .center-row{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:10px;
        }
        .col p{
            text-align:center;
        }
    </style>
    <body>
        
        <div class="owl-carousel owl-theme">
            <?php
            $sel_banner = $obj->fetch("SELECT filename FROM banners ORDER BY id DESC");
            foreach($sel_banner as $val){
            ?>
            <div class="item"><img src="https://mehndipvc.com/api/assets/<?=$val['filename']?>" alt="Image 1"></div>
            <?php } ?>
    
        </div>
        <div class="container dbd">
            <div class="row center-row">
                <div class="col" onclick="window.location.href='product-category.php'">
                    <img src="images/icon/cubes.png" alt="">
                    <p>Products</p>
                </div>
                <div class="col" onclick="window.location.href='offer.php'">
                    <img src="images/icon/discount.png" alt="">
                    <p>Offers</p>
                </div>
            </div>
            <div class="row center-row">
                <div class="col" onclick="window.location.href='view-cart.php'">
                    <img src="images/icon/trolley.png" alt="" >
                    <p>Cart</p>
                </div>
                <div class="col" onclick="window.location.href='order-history.php'">
                    <img src="images/icon/order-fulfillment.png" alt="" >
                    <p>Orders</p>
                </div>
            </div> 
            <div class="row center-row">
                <div class="col" onclick="window.location.href='my-earning.php'">
                    <img src="images/icon/salary.png" alt="">
                    <p>My Earning</p>
                </div>
                <div class="col" onclick="window.location.href='my-team.php'">
                    <img src="images/icon/teamwork.png" alt="">
                    <p>My Team</p>
                </div>
            </div>
            <div class="row center-row">
                <div class="col" onclick="window.location.href='my-account.php'">
                    <img src="images/icon/user.png" alt="">
                    <p>My Profile</p>
                </div>
                <div class="col" onclick="window.location.href='picture-category.php'">
                    <img src="images/icon/picture.png" alt="">
                    <p>Picture Gallery  </p>
                </div>
            </div>
            <div class="row center-row">
                <div class="col col-6" onclick="window.location.href='settings.php'">
                    <img src="images/icon/settings.png" alt="">
                    <p>Settings</p>
                </div>
                <div class="col col-6" onclick="window.location.href='lead-entry-form.php'">
                    <img src="images/icon/lead2.png" alt="">
                    <p>Lead Entry</p>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Owl Carousel JS -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom JS -->
        <script>
            $(document).ready(function(){
                $(".owl-carousel").owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1000: {
                            items: 1
                        }
                    }
                });
            });
        </script>
    </body>
</html>
