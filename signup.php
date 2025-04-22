<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/login.css">
</head>

<body class="center flex">
    <section class="card center">
        <div class="d-logo center flex">
            <img class="logo" src="https://mehndipvc.com/mlm-app/images/logo/logo.png" alt="logo">
        </div>
        <div class="title">
            <h2 class="center flex roboto-thin">One account</h2>
            <h2 class="center flex roboto-thin">Many possibilities</h2>
        </div>

        <form id="signupForm">
            <div class="statusMsg"></div>
            <section class="form">
                <input class="center flex roboto-thin signup_form" type="text" name="name" id="name" required placeholder="Enter your name here">
                <!--<input class="center flex roboto-thin signup_form" type="text" name="parent" id="parent" placeholder="Enter your parent name here">-->
                <input class="center flex roboto-thin signup_form" type="number" name="mobile" required id="mobile" placeholder="Enter your mobile number here">
                <input class="center flex roboto-thin signup_form" type="email" name="email" required id="email" placeholder="E-mail address">
                <input class="center flex roboto-thin signup_form" type="address" name="address" required id="address" placeholder="Enter your address here">
                <input class="center flex roboto-thin signup_form" type="password" name="password" required id="password" placeholder="Password" min="10" max="10">
                
                <div class="space-between">
                    <div class="center flex">
                        <input type="checkbox" name="rememberMe" id="rememberMe">
                        <labe class="text-size-10 roboto-thin" for="rememberMe">Remember me</label>
                    </div>
                    <div class="center flex">
                        <a class="link text-size-10 roboto-thin" href="forgot.php">
                            <span>Forgot password?</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="buttons">
                <button class="center flex button button-primary" id="registerBtn" type="submit">Sign Up</button>
            </section>

            <section class="not-member center flex">
                <span class="text-size-10 roboto-thin"> Already have an account? <a class="link" href="login.php">Login</a></span>
            </section>
        </form>
    </section>
    
<!--For SignUp-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
     $(document).ready(function(e) {
         $("#signupForm").on("submit", function(e) {
             e.preventDefault();
             $.ajax({
                url: "register.php",
                type: "post",
                data:new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function()
                {
                    $('#registerBtn').html('Processing...');
                },
                success:function(data)
                {
                    $('#registerBtn').html('Sign Up');
    
                    if(data==200)
                    {
                        $('.statusMsg').html('<p class="alert alert-success">Successfully Saved</p>');
                        setTimeout(()=>{
                            window.location.href='login.php';
                        },1500);
                    }
                    else
                    {
                        $('.statusMsg').html(data);
                    }
                }
            });
         });
     });
</script>
</body>
</html>