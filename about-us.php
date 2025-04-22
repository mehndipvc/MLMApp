<?php
session_start();
include "header.php";
?>

<style>
body {
    background-color: #f4f7f6;
}
.about-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}
.about-header {
    background-color: #3d00a5;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

.about-header h1 {
    margin: 0;
    font-size: 36px;
}

.about-section {
    padding: 20px 0;
}

.about-section h2 {
    font-size: 28px;
    color: #680658;
}

.about-section p {
    font-size: 16px;
    margin-top: 10px;
}

.contact-info {
    margin-top: 20px;
    background-color: #f4f4f4;
    padding: 20px;
}

.contact-info h3 {
    margin-top: 0;
}

.contact-info p {
    margin: 5px 0;
}
</style>

<?php
$user_id = $_SESSION['user_id'];
$sel_user = $obj->arr("SELECT name,address,mobile,email FROM users WHERE user_id='$user_id'");
?>
<div class="container my-5 about-container">
     <header class="about-header">
        <h1>About Mehndipvc</h1>
    </header>

    <section class="about-section">
        <h2>Who We Are</h2>
        <p>Mehndipvc is a leading provider of high-quality interior solutions, specializing in PVC paneling and modern interior designs. With years of experience in the industry, we have built a reputation for delivering excellence in every project we undertake. Our team of skilled professionals is dedicated to transforming spaces into elegant and functional areas that reflect our clients' unique tastes and preferences.</p>
    </section>

    <section class="about-section">
        <h2>Our Mission</h2>
        <p>Our mission is to provide innovative and sustainable interior design solutions that enhance the aesthetics and functionality of residential and commercial spaces. We aim to exceed our clients' expectations by offering superior products and services that cater to their specific needs.</p>
    </section>

    <section class="about-section">
        <h2>Our Vision</h2>
        <p>We envision a world where every space is a perfect blend of style and functionality. Our goal is to be a global leader in the interior design industry, recognized for our commitment to quality, creativity, and customer satisfaction.</p>
    </section>

    <section class="about-section contact-info">
        <h3>Contact Us</h3>
        <p>Address: Dhamaitala Lane Dakshin Jagaddal, Rajpur Sonarpur, Kol-700151</p>
        <p>Phone No.: 8695114441 </p>
        <p>Helpline: 18008911988</p>
        <p>Email ID: info@mehndipvc.com</p>
        <p>GSTIN No.: 19AAQCM4236P1ZM</p>
    </section>
</div>


<?php include "footer.php" ?>
