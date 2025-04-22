<?php
session_start();
include "header.php";

?>
<style>
    .card-body .btn-info{
        font-size: 13px;
    }
    .float {
        position: fixed;
        width: 140px;
        height: 41px;
        bottom: 38px;
        right: 40px;
        background-color: #7a000d;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
        z-index: 99;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
    }
    .float1 {
        position: fixed;
        width: 140px;
        height: 41px;
        bottom: 38px;
        left: 40px;
        background-color: #7a000d;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
        z-index: 99;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
    }
</style>

<div class="container catContainer mt-4">
    <div class="row">
        
        <?php
        
        $user_id = $_COOKIE['user_id'];
        
        $consolidated_orders_data = $obj->fetch("SELECT * FROM `withdraw` WHERE user_id='$user_id' ORDER BY id DESC");
        $total_withdraw = $obj->arr("SELECT SUM(amount) as total FROM `withdraw` WHERE user_id='$user_id' AND status='Approved'");
        
        foreach($consolidated_orders_data as $sel_val){
            $status = $sel_val['status'];
            $style = '';
            
            if ($status === 'Pending') {
                $style = 'color: orange; font-weight: bold;';
            } elseif ($status === 'Reject') {
                $style = 'color: red; font-weight: bold;';
            } else {
                $style = 'color: green; font-weight: bold;';
            }
        ?>
        
        <div>
            <p class="card-text p-3 text-center"><strong>Total Withdraw: <span style="font-family:calibri;">₹</span> </strong> 
                <?=$total_withdraw['total']==''?0:$total_withdraw['total'] ?>
            </p>
        </div>
        
        <div class="col-md-4 mb-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> <span style="font-family:calibri;"> ₹ </span> <?=$sel_val['amount']?></h5>
   
              <p class="card-text"><strong>Date:</strong> <?=$sel_val['cr_date']?></p>
              <p class="card-text">
                    <strong>Status:</strong> <span style="<?= $style ?>"> <?= $status ?> </span>
                </p>
             
            </div>
          </div>
        </div>
        <?php }
        if(empty($consolidated_orders_data)){
        ?>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">Withdrawal History is Empty</h5>
              
            </div>
          </div>
        </div>
        <?php } ?>
        

    </div>
</div>


<?php include "footer.php" ?>

<script>
    $('#withdraw-form').on("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        
        $.ajax({
            url: "add-withdraw.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $("#uploadBtn").attr('disabled', 'disabled');
                $('#uploadBtn').html('Processing...');
            },
            success: function(response) {
                $('#uploadBtn').html('Upload'); // Reset button text after processing
                
                if(response.trim() ==200) {
                    $('.errorMsg').html('<p class="alert alert-success">Successfully uploaded</p>');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    $('.errorMsg').html(response);
                    $("#uploadBtn").removeAttr('disabled');
                }
            }
        });
    });
</script>