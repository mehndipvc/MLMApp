<?php
session_start();
if(!isset($_COOKIE['mobile']))
{
    echo '<script>window.location.href="login.php"</script>';
    exit;
}
include("config.php");
$cat_id=$_GET['id'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="about-banner row" id="navbar">
            <div class="left-banner col-sm-8">
               <?php
               
                $server = basename($_SERVER['SCRIPT_FILENAME']); // Use SCRIPT_FILENAME to get the current script name
                $title = ''; // Initialize title variable
                
                $sel_category=$obj->arr("SELECT name FROM category WHERE id='$cat_id'");
                
                switch ($server) {
                    case 'product-category.php':
                        $title = 'Product Category';
                        break;
                    case 'product.php':
                        $title = $sel_category['name'];
                        break;
                    case 'product-details.php':
                        $title = 'Product Details';
                        break;
                    case 'my-earning.php':
                        $title = 'My Earning';
                        break;
                    case 'my-team.php':
                        $title = 'My Team';
                       break; 
                    case 'member-profile.php':
                        $title = 'My Profile';
                        break;
                    case 'my-account.php':
                        $title = 'My Account';
                        break;
                     case 'view-cart.php':
                        $title = 'View Cart';
                        break;
                    case 'offer.php':
                        $title = 'Offers';
                        break;
                     case 'order-history.php':
                        $title = 'Order History';
                        break;
                    case 'picture-category.php':
                        $title = 'Gallery Category';
                        break;
                     case 'picture-details.php':
                        $title = 'Gallery';
                        break;
                    case 'history.php':
                        $title = 'Withdrawal History';
                        break;
                    case 'about-us.php':
                        $title = 'About Us';
                        break;
                    case 'privacy-policy.php':
                        $title = 'Privacy Policy';
                        break;
                    case 'terms.php':
                        $title = 'Terms And Conditions';
                        break;
                    case 'settings.php':
                        $title = 'Settings';
                        break;
                    case 'lead-entry-form.php':
                        $title = 'Lead Entry';
                        break;
                    case 'my-earning-details.php':
                        $title = 'Earning Details';
                        break;
                    default:
                        $title = 'Default Title'; // Optional: handle cases not covered
                        break;
                }
                ?>
                <span onclick="window.history.back();"><i class="fa-solid fa-angle-left"></i></span>
                <span class="banner-txt"><?= $title ?></span>

            </div>
            <div class="right-banner col-sm-4 text-end">
                <span class="toogleMenu"><i class="fa-solid fa-bars"></i></span>
            </div>
            <div class="sidebar-wrap">
                <span class="cross toogleMenu"><i class="fa-solid fa-circle-xmark"></i></span>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product-category.php">Products</a></li>
                    <li><a href="offer.php">Offers</a></li>
                    <li><a href="view-cart.php">Cart</a></li>
                    <li><a href="order-history.php">Orders</a></li>
                    <li><a href="my-earning.php">My Earning</a></li>
                    <li><a href="my-team.php">My Team</a></li>
                    <li><a href="my-account.php">My Profile</a></li>
                    <li><a href="picture-category.php">My Picture Gallery</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="lead-entry-form.php">Lead Entry</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>