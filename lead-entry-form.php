<?php
session_start();
include "header.php";
?>

<style>
body {
    background-color: #f4f7f6;
}
.about-container {
  max-width: 600px;
  margin: auto;
  padding: 0px 30px;

}
.form-control {
  border-radius: 30px;
  padding: 7px 15px;
}
.form-label {
  font-weight: bold;
  margin-bottom: 8px;
}
.btn-submit {
  width: 100%;
  background: linear-gradient(45deg, #007bff, #00d4ff);
  border: none;
  border-radius: 30px;
  padding: 12px;
  font-size: 18px;
  font-weight: bold;
  color: white;
  transition: all 0.3s ease;
}
.btn-submit:hover {
  background: linear-gradient(45deg, #00d4ff, #007bff);
  transform: scale(1.02);
}
.form-control {
    font-size: 0.95rem;
}
</style>

<?php
$user_id = $_SESSION['user_id'];
$sel_user = $obj->arr("SELECT name,address,mobile,email FROM users WHERE user_id='$user_id'");
?>
<div class="container my-3 about-container">
<h3 class="text-center mb-2 mt-2">Lead Entry</h3>
    <form id="lead-entry">
        <div class="mb-3">
     
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
        </div>
        <div class="mb-3">

            <input type="text" class="form-control" id="company" name="company" placeholder="Company name">
        </div>
        <div class="mb-3">
       
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile number" required>
        </div>
        <div class="mb-3">
       
            <input type="email" class="form-control" id="email" name="email" placeholder="Email address">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Image</label>
            <input type="file" class="form-control" name="image">
        </div>
        <div class="mb-3">

            <textarea class="form-control" id="address" rows="3" placeholder="Address" name="address" rquired></textarea>
        </div>
        <div class="mb-3 status_msg" style="font-size:13px;"></div>
        <button type="submit" class="btn btn-submit btn-form-submit">Submit</button>
    </form>
    
   
</div>


<?php include "footer.php" ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#lead-entry").on("submit", function(e) {
             e.preventDefault();
            
            $.ajax({
              url: "add-lead.php",
              type: 'POST',
              data: new FormData(this),
              cache:false,
              contentType:false,
              processData:false,
              beforeSend: function()
              {
                  $('.btn-form-submit').html('Processing...');
              },
                success: function(response) {

                    $('.btn-form-submit').html("Submit");
                    if(response==200)
                      {
                         $('.status_msg').html('<p class="alert alert-success">Information Successfully Submitted</p>');
                         setTimeout(location.reload.bind(location), 1500);
                      }
                      else
                      {
                          $('.status_msg').html(response);
                      }
                    
                },
                error: function() {
                    $('.btn-form-submit').html("Submit");
                    $('.status_msg').html('<p class="alert alert-danger status_msg">An error occurred. Please try again.</p>');
                }
            });
        });
    });
</script>