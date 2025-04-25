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
        $from_id = $_GET['user_id'];
        $sel_wallet = $obj->arr("SELECT SUM(amount) as total FROM `transaction` WHERE from_id='$from_id' AND user_id='$user_id'");
        $sel_from=$obj->arr("SELECT name FROM users WHERE user_id='$from_id'");
        ?>
        <div>
            <h5 class="card-title text-center"><?=$sel_from['name']?></h5>
            <p class="card-text text-center"><strong>User ID:</strong> <?=$from_id?></p>
            <p class="card-text text-center"><strong>Total Earning: <span style="font-family:calibri;">₹</span> </strong> <?=$sel_wallet['total']?></p>
        </div>
        <?php
        
        
        $consolidated_orders_data = $obj->fetch("SELECT * FROM `transaction` WHERE user_id='$user_id' AND from_id='$from_id'");
        
        
        foreach($consolidated_orders_data as $sel_val){
            $order_id=$sel_val['order_id'];
            $sel_order=$obj->arr("SELECT date,invoice_path FROM orders WHERE order_id='$order_id'");
        
            
        ?>
        
        
        
        <div class="col-md-4 mb-2">
          <div class="card">
            <div class="card-body">
              <p class="card-text"><strong>Order ID:</strong> <?=$sel_val['order_id']?></p>
              <p class="card-text"><strong>Date:</strong> <?=$sel_order['date']?></p>
              <p class="card-text"><strong>Earning Amount:</strong> <span style="font-family:calibri;"> ₹ </span> <?=$sel_val['amount']?></p>
              <?php
                if($sel_order['invoice_path']!=''){
                ?>
              <a href="https://app.pvcinterior.in/<?=$sel_order['invoice_path']?>" download class="btn btn-primary">View Invoice</a>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php }
        if(empty($consolidated_orders_data)){
        ?>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">Earning History is Empty</h5>
              
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