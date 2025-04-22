<?php
session_start();
include "header.php";
?>

<style>

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 20px;
    color: #333;
    background-color: #f4f7f6;
}

h1, h2, h3 {
    color: #680658;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.section {
    margin-bottom: 20px;
}

.section h2 {
    margin-bottom: 10px;
}
</style>

<?php
$user_id = $_SESSION['user_id'];
$sel_user = $obj->arr("SELECT name,address,mobile,email FROM users WHERE user_id='$user_id'");
?>
<div class="container">
        <h1>Privacy Policy</h1>
        <p>Last updated: 16-09-2024</p>

        <div class="section">
            <h2>Introduction</h2>
            <p>Welcome to Mehndipvc. Your privacy is important to us. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website. Please read this privacy policy carefully. If you do not agree with the terms of this privacy policy, please do not access the site.</p>
        </div>

        <div class="section">
            <h2>Information We Collect</h2>
            <p>We may collect information about you in a variety of ways. The information we may collect on the Site includes:</p>
            <ul>
                <li><strong>Personal Data:</strong> Personally identifiable information, such as your name, shipping address, email address, and telephone number, that you voluntarily give to us when you register on the Site or when you choose to participate in various activities related to the Site.</li>
                <li><strong>Derivative Data:</strong> Information our servers automatically collect when you access the Site, such as your IP address, your browser type, your operating system, your access times, and the pages you have viewed directly before and after accessing the Site.</li>
            </ul>
        </div>

        <div class="section">
            <h2>Use of Your Information</h2>
            <p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the Site to:</p>
            <ul>
                <li>Create and manage your account.</li>
                <li>Process your transactions and send you related information, including purchase confirmations and invoices.</li>
                <li>Improve the quality, functionality, and overall experience of our website.</li>
                <li>Communicate with you about products, services, offers, promotions, and events, and provide other news and information we think will be of interest to you.</li>
            </ul>
        </div>

        <div class="section">
            <h2>Disclosure of Your Information</h2>
            <p>We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>
            <ul>
                <li><strong>By Law or to Protect Rights:</strong> If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others.</li>
                <li><strong>Business Transfers:</strong> We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.</li>
            </ul>
        </div>

        <div class="section">
            <h2>Security of Your Information</h2>
            <p>We use administrative, technical, and physical security measures to help protect your personal information. While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable, and no method of data transmission can be guaranteed against any interception or other type of misuse.</p>
        </div>

        <div class="section">
            <h2>Policy for Children</h2>
            <p>We do not knowingly solicit information from or market to children under the age of 13. If we learn we have collected personal information from a child under age 13 without verification of parental consent, we will delete that information as quickly as possible. If you believe we might have any information from or about a child under 13, please contact us at [Contact Information].</p>
        </div>

        <div class="section">
            <h2>Changes to This Privacy Policy</h2>
            <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>
        </div>

        <div class="section">
            <h2>Contact Us</h2>
            <p>If you have questions or comments about this Privacy Policy, please contact us at:</p>
            <p>Email: <a href="mailto:info@mehndipvc.com">info@mehndipvc.com</a></p>
            <p>Phone: 8695114441 </p>
            <p>Address: Dhamaitala Lane Dakshin Jagaddal, Rajpur Sonarpur Kol-700151</p>
        </div>
    </div>


<?php include "footer.php" ?>
