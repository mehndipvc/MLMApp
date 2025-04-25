<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <style>
        input[type="text"] {
            border-radius: 5px;
            margin: 10px 0;
            padding: 8px 0 8px 5px;
            width: 300px;
        }
    </style>
    
</head>
<body class="center flex">
    <section class="card1 center">
        <div class="d-logo center flex">
            <img class="logo" src="https://app.pvcinterior.in/images/logo/logo.png" alt="logo">
        </div>
        <div class="title">
            <h2 class="center flex roboto-thin">Forgot Password</h2>
        </div>
        <div class="status_msg" style="font-size:11px;"></div>
        <form id="forgotForm">
            
            <section class="form">
                <input class="center flex roboto-thin" type="text" name="email" id="email" placeholder="Enter your Email or Mobile" required>
                
                <div class="space-between">
                    
                    <div class="center flex">
                        <a class="link text-size-10 roboto-thin" href="login.php">
                            <span>Have an Account?</span>
                        </a>
                    </div>
                </div>
            </section>
        
            <section class="buttons">
                <button class="center flex button button-primary" id="forgotBtn" type="submit">Submit</button>
            </section>
        
            <section class="not-member center flex">
                <span class="text-size-10 roboto-thin"> Not a member yet? <a class="link" href="signup.php">Sign Up</a></span>
            </section>
        </form>
    </section>
    
<!--For Login-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#forgotForm").on("submit", function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "add-forgot-password.php",
                type: 'POST',
                data: new FormData(this),
              cache:false,
              contentType:false,
              processData:false,
              beforeSend: function()
              {
                  $('#forgotBtn').html('Processing...');
              },
                success: function(response) {
                    console.log(response)
                    $('#forgotBtn').html("Submit");
                    if(response==200)
                      {
                         $('.status_msg').html('<p class="alert alert-success">OTP Send To Your Email....!</p>');
                         setTimeout(function() {
                            window.location.href="otp-form.php";
                        }, 1500);
                      }
                      else
                      {
                          $('.status_msg').html(response);
                      }
                    
                },
                error: function() {
                    $('#forgotBtn').html("Submit");
                    $('.status_msg').html('<p class="alert alert-danger status_msg">An error occurred. Please try again.</p>');
                }
            });
        });
    });
</script>
</body>
</html>