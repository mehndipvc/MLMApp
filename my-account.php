<?php
session_start();
include "header.php";
?>

<style>
body {
    background-color: #f4f7f6;
}
.account-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}
.account-container h3, .chart-container h3 {
    margin-bottom: 20px;
    font-size: 1.5rem;
    color: #333;
}
.form-group label {
    font-weight: bold;
    color: #555;
}
.btn-custom {
    background-color: #007bff;
    color: white;
    border: none;
}
.btn-custom:hover {
    background-color: #0056b3;
}
.modal-header {
    border-bottom: 1px solid #e9ecef;
}
.modal-body {
    padding: 2rem;
}
.modal-content {
    border-radius: 10px;
}

.chart-container {
    background-color: #f9f9f9; /* Light background color for contrast */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 20px; /* Space around content */
    margin-top: 20px; /* Space from the top */
}

.rate-list {
    list-style-type: none; /* Remove default list styling */
    padding: 0; /* Remove default padding */
    margin: 0; /* Remove default margin */
}

.rate-item {
    display: flex; /* Align items horizontally */
    justify-content: space-between; /* Space between item and link */
    align-items: center; /* Center items vertically */
    padding: 10px 0; /* Padding around each item */
    border-bottom: 1px solid #ddd; /* Separator line between items */
}

.rate-item:last-child {
    border-bottom: none; /* Remove bottom border for the last item */
}

.rate-name {
    font-size: 16px; /* Font size for item names */
    color: #333; /* Dark text color for readability */
}

.download-link {
    text-decoration: none; /* Remove underline from link */
    color: #007bff; /* Primary color for links */
    font-size: 14px; /* Font size for links */
}

.download-link:hover {
    text-decoration: underline; /* Underline on hover for better UX */
    color: #0056b3; /* Darker color on hover */
}


</style>

<?php
$user_id = $_COOKIE['user_id'];
$sel_user = $obj->arr("SELECT name,address,mobile,email FROM users WHERE user_id='$user_id'");
?>
<div class="container my-5">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <!-- Update Profile Section -->
            <div class="account-container">
                <h3>Update Profile</h3>
                <form id="update-profile">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?=$sel_user['name']?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?=$sel_user['email']?>" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="mobile" placeholder="Enter your phone number" value="<?=$sel_user['mobile']?>" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">Address</label>
                        <textarea class="form-control" name="address" id="phone"><?=$sel_user['address']?></textarea>
                    </div>
                    <input type="hidden" name="user_id" value="<?=$user_id?>">
                    <button type="submit" class="btn btn-custom">Update Profile</button>
                </form>
                <div class="show-msg mt-2"></div>
            </div>
        </div>

        <div class="col-md-3 mx-auto">
            <!-- Change Password Button -->
            <div class="account-container text-center" style="display:flex;flex-direction:column;gap:5px;">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
                <button type="button" class="btn btn-info" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="chart-container">
                <h3>My Documents</h3>
                <ul class="rate-list">
                <?php
                $sel_rate = $obj->fetch("SELECT file_path, name FROM rate_chart WHERE user_id='All User' || user_id='$user_id'");
                foreach($sel_rate as $val_rate){
                ?>
                    <li class="rate-item">
                        <span class="rate-name"><?=$val_rate['name']?></span>
                        <a class="download-link" href="../api/assets/<?=$val_rate['file_path']?>" download>Download</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>

        
        
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-password">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" name="old_password" placeholder="Enter your current password">
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" name="new_password" placeholder="Enter a new password">
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm your new password">
          </div>
          <input type="hidden" name="user_id" value="<?=$user_id?>">
          <button type="submit" class="btn btn-custom btn-change">Change Password</button>
        </form>
        <div class="msg-pass mt-2"></div>
      </div>
    </div>
  </div>
</div>


<?php include "footer.php" ?>

<script>
    $("#form-password").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            url:"update-password.php",
            type:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $(".btn-change").html('Processing...');
            },
            success:function(data){
                $(".btn-change").html('Change Password');
                if(data==200){
                    $('.msg-pass').html('<p class="alert alert-primary">Successfully Updated</p>');
                    setTimeout(location.reload.bind(location), 1500);
                }else{
                    $('.msg-pass').html(data);
                }
            }
        })
    })


    $("#update-profile").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            url:"update-profile.php",
            type:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $(".btn-custom").html('Processing...');
            },
            success:function(data){
                $(".btn-custom").html('Update Profile');
                if(data==200){
                    $('.show-msg').html('<p class="alert alert-primary">Successfully Updated</p>');
                    setTimeout(location.reload.bind(location), 1500);
                }else{
                    $('.show-msg').html(data);
                }
            }
        })
    })
</script>
