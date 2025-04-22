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
        $sel_wallet = $obj->arr("SELECT wallet FROM `users` WHERE user_id='$user_id'");
        ?>
        <div>
            <p class="card-text p-3 text-center"><strong>Total Earning: <span style="font-family:calibri;">₹</span> </strong> <?=$sel_wallet['wallet']?></p>
        </div>
        
        <?php
        $consolidated_orders_data = $obj->fetch("SELECT * FROM `transaction` WHERE user_id='$user_id'");

        $userIds=[];
        foreach($consolidated_orders_data as $sel_val){
            $order_id=$sel_val['order_id'];
            $sel_order=$obj->arr("SELECT date,invoice_path FROM orders WHERE order_id='$order_id'");
            $from_id=$sel_val['from_id'];
            $sel_from=$obj->arr("SELECT name FROM users WHERE user_id='$from_id'");
            if(!in_array($from_id,$userIds)){

                $userIds[]=$from_id;
                $sel_order_amount=$obj->arr("SELECT SUM(amount) as total FROM transaction WHERE from_id='$from_id' and user_id='$user_id'");
        ?>
        
        <div class="col-md-4 mb-2" onclick="window.location.href='my-earning-details.php?user_id=<?=$from_id ?>'">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?=$sel_from['name']?></h5>
              <p class="card-text"><strong>User ID:</strong> <?=$from_id?></p>

              <p class="card-text"><strong>Total Earning:</strong> <span style="font-family:calibri;"> ₹ </span> <?=$sel_order_amount['total']?></p>
              
            </div>
          </div>
        </div>
        <?php } }
        if(empty($consolidated_orders_data)){
        ?>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">Earning History is Empty</h5>
              
            </div>
          </div>
        </div>
        <?php }else{ ?>
        
        
        <!--Withdraw Modal Start-->
        <div class="container my-2">
            <div id="data-container" class="row gy-3">
                <a href="history.php" class="float1">
                    History
                </a>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#withdraw-modal" class="float">
                    Withdraw
                </a>
            </div>
        </div>
        <?php } ?>
        
        <div class="modal fade" id="withdraw-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Withdraw Amount</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="withdraw-form">
              <div class="modal-body">
                  
                  <div class="mb-3">
                    <label for="fileUpload" class="form-label">Enter Amount</label>
                    <input type="number" max="<?=$sel_wallet['wallet']?>" class="form-control" id="amount" name="amount" required>
                    <input name="user_id" value="<?=$user_id?>" type="hidden">
                  </div>
                  <div class="mb-3 errorMsg"></div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="uploadBtn">Submit</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!--Withdraw Modal-->
        

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