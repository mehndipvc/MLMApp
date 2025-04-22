<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
    .account-title {
        font-size: 23px;
        font-weight: 600;
        margin-bottom: 5px;
        text-align: center;
    }
    .account-subtitle {
        color: #4c4c4c;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }
    input[type="text"] {
        border-radius: 5px;
        margin: 10px 0;
        padding: 8px 0 8px 5px;
        width: 300px;
    }
    </style>
</head>
<body class="center flex">
    <section class="card center">
        <div class="d-logo center flex">
            <img class="logo" src="https://mehndipvc.com/mlm-app/images/logo/logo.png" alt="logo">
        </div>
        <div class="title">
            <h2 class="center flex account-title">Welcome Back!</h2>
            <p class="center flex account-subtitle">Please Log In</p>
        </div>


        <form id="loginForm">
            <div class="status_msg"></div>
            <section class="form">
                <input class="center flex roboto-thin" type="text" name="mobile" id="mobile" placeholder="Email or Mobile" required>
                <input class="center flex roboto-thin" type="password" name="password" id="password" placeholder="Password" required>
                <div class="space-between">
                    <div class="center flex">
                        <input type="checkbox" name="rememberMe" id="rememberMe">
                        <label class="text-size-10 roboto-thin" for="rememberMe">Remember me</label>
                    </div>
                    <div class="center flex">
                        <a class="link text-size-10 roboto-thin" href="forgot.php">
                            <span>Forgot password?</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="buttons">
                <button class="center flex button button-primary" id="loginBtn" type="submit">Sign in</button>
            </section>

            <section class="not-member center flex">
                <span class="text-size-10 roboto-thin">Not a member yet? <a class="link" href="signup.php">Sign up</a></span>
            </section>
        </form>
    </section>
    
<!-- For Login -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#loginForm").on("submit", function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
       
        $.ajax({
            url: "verify.php",
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#loginBtn').html("Processing...");
            },
            success: function(response) {
                $('#loginBtn').html("Sign in");

                var data = JSON.parse(response);
                
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                } else {
                    $('.status_msg').html('<p class="alert alert-danger">' + data.message + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error); // Debugging: Log any errors to the console
                $('#loginBtn').html("Sign in");
                $('.status_msg').html('<p class="alert alert-danger">Something went wrong, please try again.</p>');
            }
        });
    });
});

</script>
</body>
</html>