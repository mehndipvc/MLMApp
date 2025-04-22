<?php

//echo '<br><br><br><br><br><br><br><br><br><center><h1>Application is Under Maintenance!</h2></center>';
//exit;

session_start();
if(isset($_COOKIE['mobile']))
{
    echo '<script>window.location.href="dashboard.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        * {
            font-family: "Poppins", sans-serif;
        }

        .banner {
            background-image: url(images/bg.png);
            width: 100%;
            height: 30vh;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .banner::before {
            content: '';
            background-image: url(images/bg.jpg);
            position: absolute;
            width: 100%;
            height: 30vh;
            background-size: cover;
            opacity: 0.3;
        }

        .container-fluid {
            padding: 0;
            margin: 0;
            position: relative;
        }

        .banner img {
            width: 118px;
            height: 67px;

        }

        .logo {
            position: absolute;
            top: 18%;
            left: 31%;
            width: 150px;
            height: 150px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .btn-pm2 {
            display: block;
            width: 250px;
            height: 48px;
            background-color: #560f0d;
            border-radius: 25px;
            color: #fff;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
        }

        .btn-grp {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 25px;
            width: 100%;
            /* height: 27vh; */
            margin: 0 auto;
            position: absolute;
            top: 150%;
        }

        .btn-pm {
            width: 250px;
            height: 48px;
            border: none;
            border: 1px solid #560f0d;
            border-radius: 25px;
            color: #560f0d;
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
        }

        .social-group {
            position: absolute;
            top: 234%;
            left: 33%;
        }

        .social-btn-group {
            display: flex;
            gap: 10px;
        }

        .social-btn-group img {
            width: 40px;
            height: 40px;
            background-color: #fff;
            padding: 5px;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .social-group p {
            padding-left: 29px;
            padding-bottom: 10px;
            margin-bottom: 0 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="banner">
            <div class="logo">
                <img src="images/logo.png" alt="">
            </div>
        </div>
        <div class="btn-grp">
            <button class="btn-pm" onclick="window.location.href='signup.php'">Signup</button>
            <button class="btn-pm2" onclick="window.location.href='login.php'">Login</button>
        </div>
        <div class="social-group">
            <p>Find us on:</p>
            <div class="social-btn-group">
                <img src="images/communication.png" alt="">
                <img src="images/whatsapp.png" alt="">
                <img src="images/instagram.png" alt="">
            </div>
        </div>
    </div>
</body>

</html>