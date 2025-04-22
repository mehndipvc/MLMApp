<?php include("header.php") ?>
<?php
if(!empty($_GET['id']))
{
    $id=$_GET['id'];
    $fet_data=$obj->arr("SELECT * FROM users WHERE id='$id'");
    $user_id=$fet_data['user_id'];
    $order_row=$obj->fetch("SELECT * FROM orders WHERE user_id='$user_id' ORDER BY order_id DESC");
    
}
else
{
    echo '<script>window.location.href="history.back()"</script>';
    exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-5">
            <div class="card">
                <div class="card-header">
                    Member Profile
                </div>
                <div class="card-body">
                    <p>User ID : <?= $fet_data['user_id'] ?></p>
                    <p><?= $fet_data['name'] ?></p>
                    <p><?= $fet_data['mobile'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="card">
                <div class="card-header">
                    Order History
                </div>
                <?php
                foreach($order_row as $order_data){
                    $order_id=$order_data['order_id'];
                    if($order_data['type']!='Custom')
                    {
                        $order_data2 = $obj->arr("SELECT SUM(total_price) AS total_sum FROM order_item WHERE order_id='$order_id'");
                        $total_amt=$order_data2['total_sum'];
                    }
                    else
                    {
                        $total_amt=$order_data['price'];
                    }
                
                ?>
                <div class="card-body">
                    <p>Order ID : <?= $order_data['order_id'] ?></p>
                    <p>Order Date : <?= $order_data['date'] ?></p>
                    <p>Total amount : <?= $total_amt ?></p>
                    <p>Status : <?= $order_data['status'] ?></p>
                    <p>Invoice : 
                    <?php if(!empty($order_data['invoice_path'])){?>
                    <a href="<?= $order_data['invoice_path'] ?>" download>Download</a></p>
                    <?php } ?>
                    <hr>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php") ?>