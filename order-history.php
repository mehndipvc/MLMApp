<?php
session_start();
if (empty($_COOKIE['mobile'])) {
    echo '<script>window.location.href="login.php"</script>';
}
?>

<?php include "header.php" ?>

<?php
$user_id = $_COOKIE['user_id'];
$sel_user = $obj->arr("SELECT name FROM users WHERE user_id='$user_id'");
?>

<style>
    .order-card {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        transition: transform 0.3s, box-shadow 0.3s;
        background-color: #fff;
        overflow: hidden;
        padding: 1rem;
    }

    .order-card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: #f0f4f8;
        border-bottom: 1px solid #ddd;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .order-header-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 1;
    }

    .order-id {
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
    }

    .order-date {
        font-size: 1rem;
        color: #777;
    }

    .order-status {
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        text-transform: uppercase;
        color: #fff;
        display: inline-block;
        white-space: nowrap;
        text-align: center;
        min-width: 120px;
    }

    .status-pending {
        background-color: #ff9800;
    }

    .status-completed {
        background-color: #4caf50;
    }

    .status-cancelled {
        background-color: #f44336;
    }

    .card-body {
        padding: 1rem;
    }

    .card-body p {
        margin-bottom: 0.5rem;
        font-size: 1rem;
        color: #555;
    }

    .card-body strong {
        color: #333;
    }

    .item-list {
        margin-top: 0.5rem;
        border-top: 1px solid #ddd;
        padding-top: 0.5rem;
    }

    .item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .order-card {
            margin-bottom: 1rem;
        }

        .card-header {
            flex-direction: column;
            text-align: center;
        }

        .order-header-info {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .order-status {
            margin-top: 0.5rem;
        }
    }
</style>

<div class="container-fluid mt-4">
    <h1 class="mb-4">Order History</h1>
    <div id="orderList" class="list-group">
        
        <?php
        function getStatusClass($status) {
            switch ($status) {
                case 'Pending Confirmation':
                    return 'status-pending';
                case 'Confirmed':
                    return 'status-completed';
                case 'Cancelled':
                    return 'status-cancelled';
                default:
                    return '';
            }
        }
        
        $sel_order = $obj->fetch("SELECT * FROM orders WHERE user_id='$user_id' ORDER BY id DESC");
        foreach ($sel_order as $val_order) {
        ?>
        
        <div class="order-card card">
            <div class="card-header">
                <div class="order-header-info">
                    <div class="order-id">Order #<?=$val_order['order_id']?></div>
                    <div class="order-date">
                        <?php
                        $old_date = $val_order['date'];
                        $formatted_date = DateTime::createFromFormat('Y-d-m', $old_date);
                        if ($formatted_date) {
                            echo $formatted_date->format('M, d Y');
                        } else {
                            echo "Invalid date";
                        }
                        ?>
                    </div>
                </div>
                <span class="order-status <?= getStatusClass($val_order['status']) ?>">
                    <?=$val_order['status']?>
                </span>
            </div>
            <div class="card-body">
                <div class="item-list">
                    <strong>Items:</strong>
                    <?php
                    $order_id=$val_order['order_id'];
                    // Assuming items are stored in a related table
                    $order_items = $obj->fetch("SELECT * FROM order_item WHERE order_id='$order_id'");
                    foreach ($order_items as $item) {
                    ?>
                    <div class="item">
                        <span><?=$item['name']?></span>
                        <span>Qty: <?=$item['quantity']?></span>
                    </div>
                    <?php } ?>
                </div>
                <p><strong>Total Price:</strong> <span style="font-family:calibri;">₹</span> <?=$val_order['price']?></p>
                <p><strong>Time:</strong> <?=$val_order['time']?></p>
                <p><strong>Customer Name:</strong> <?=$val_order['name']?></p>
                <?php if ($val_order['temp_path'] != '') { ?>
                <p><strong>Invoice:</strong> <a class="btn btn-info" href="https://app.pvcinterior.in/<?=$val_order['temp_path']?>" download>Download</a></p>
                <?php } ?>
            </div>
        </div>
        
        <?php }
        if (empty($sel_order)) {
        ?>
        <div class="order-card card">
            <div class="card-body text-center">
                No Order Found
            </div>
        </div>
        <?php } ?>
        
    </div>
</div>

<input type="hidden" id="userId" value="<?=$user_id?>">

<?php include "footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    let userId = $("#userId").val();
</script>
