<?php
session_start();
if(!isset($_COOKIE['mobile']))
{
    echo '<script>window.location.href="login.php"</script>';
}
?>

<?php include "header.php" ?>

<?php
$user_id=$_COOKIE['user_id'];
$sel_cart=$obj->fetch("SELECT * FROM cart_item WHERE user_id='$user_id'");

$sel_user=$obj->arr("SELECT name FROM users WHERE user_id='$user_id'");
?>


<style>
.cart-container {
    max-width: 92%;
    width: 1000px;
    margin: 16px 0px 0px 13px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 20px;
    box-sizing: border-box;
    overflow-x: clip;
}

.cart-container1 {
    max-width: 100%;
    width: 1000px;
    margin: 20px auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 20px;
    box-sizing: border-box;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.cart-item {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-image {
    width: 80%;
    height: 200px;
    object-fit: contain;
    border-radius: 8px;
    margin-right: 15px;
    flex-shrink: 0;
}

.cart-item-details {
    flex: 1;
    min-width: 200px;
}

.cart-item-name {
    font-size: 18px;
    margin: 0;
}

.cart-item-price {
    color: #333;
    font-size: 16px;
    margin: 5px 0;
}

.quantity-controls {
    display: flex;
    align-items: center;
    margin-top: 10px;
}

.quantity-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    margin: 0 5px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.quantity-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.quantity-input {
    width: 50px;
    text-align: center;
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 4px;
    font-size: 16px;
    margin: 0 5px;
}

.remove-btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    flex-shrink: 0;
}

.remove-btn:hover {
    background-color: #c82333;
}

.cart-total {
    margin-top: 20px;
    text-align: right;
}

#total-price {
    font-weight: bold;
}

#checkout-btn {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 18px;
}

#checkout-btn:hover {
    background-color: #218838;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .cart-container {
        width: 100%;
        padding: 10px;
    }
    
    .cart-container1 {
        width: 100%;
        padding: 10px;
    }

    .cart-item {
        flex-direction: column;
        align-items: center;
    }

    .cart-item-image {
        margin: 0 0 10px 0;
        //width: 100%;
        height: 200px;
    }

    .cart-item-details {
        width: 100%;
    }

    .quantity-controls {
        margin-top: 10px;
        width: 100%;
        justify-content: center;
    }

    .remove-btn {
        width: 100%;
        margin-top: 10px;
    }

    #checkout-btn {
        width: 100%;
        margin-top: 20px;
    }
}

@media (max-width: 480px) {
    .quantity-btn {
        padding: 3px 6px;
        font-size: 14px;
    }

    .quantity-input {
        width: 40px;
        font-size: 14px;
    }

    .cart-item-name {
        font-size: 16px;
    }

    .cart-item-price {
        font-size: 14px;
    }

    #checkout-btn {
        font-size: 16px;
    }
}
</style>



<input type="hidden" id="userId" value="<?=$user_id?>">
<input type="hidden" id="userName" value="<?=$sel_user['name']?>">

<div class="cart-container">
    <h1>Your Cart</h1>
    
    <?php
    
        $total_amount = 0;
        foreach ($sel_cart as $val_cart) {
            $amt = $val_cart['quantity'] * $val_cart['price'];
            $total_amount += $amt;
        ?>
            <div class="cart-item" id="item-cart<?=$val_cart['item_id']?>" style="display:flex;justify-content:center;align-items:center;flex-direction:row;width:100%;">
                <div style="width:48%">
                    <img src="../<?= htmlspecialchars($val_cart['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="Product Image" class="cart-item-image">
                </div>
                <div style="width:48%">
                     <div class="cart-item-details">
                    <h2 class="cart-item-name"><?= htmlspecialchars($val_cart['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <p class="cart-item-price">
                        <span style="font-family: calibri;">₹ </span>
                        <?= htmlspecialchars($val_cart['price'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div class="quantity-controls">
                        <button class="quantity-btn decrement" onclick="cartUpdate('minus', <?=$val_cart['item_id']?>, this)">-</button>
                        <input type="text" class="quantity-input" id="qty<?=$val_cart['item_id']?>" value="<?=$val_cart['quantity']?>" readonly>
                        <button class="quantity-btn increment" onclick="cartUpdate('plus', <?=$val_cart['item_id']?>, this)">+</button>

                    </div>
                </div>
                <button class="remove-btn" onclick="removeCart(<?=$val_cart['item_id']?>)" data-item-id="<?= htmlspecialchars($val_cart['item_id'], ENT_QUOTES, 'UTF-8') ?>">Remove</button>
                </div>
                
               
            </div>
        <?php } ?>

    
</div>

<div class="show-msg">
    
</div>

<div class="cart-container1">
    <?php
    if($total_amount==0){
    ?>
    <h3 class="text-center">Cart is empty</h3>
    <?php }else{ ?>
    <div class="cart-total">
        <p>Total Amount: <span style="font-family:calibri;">₹ </span> <span id="total-price"><?=$total_amount?></span></p>
        <button id="checkout-btn" onclick="addOrder()">Place Order</button>
    </div>
    <?php } ?>
</div>



<?php include "footer.php" ?>


<script>
let userId=$("#userId").val();
let userName=$("#userName").val();

function addOrder(){
    $.ajax({
        url: 'add-order.php',
        type: 'POST',
        data: { user_id:userId,userName:userName},
        dataType: 'json',
        beforeSend: function() {
            $('#checkout-btn').html('Processing...');
        },
        success: function(response) {
            $('#checkout-btn').html('Place Order');
            if (response==200) {
                
                $.toast({
                    text: "Order Placed Successfully", 
                    heading: 'Information', 
                    icon: 'success',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 1700,
                    stack: 5, 
                    position: 'mid-center',          
                    textAlign: 'center', 
                    loader: true, 
                    loaderBg: '#9EC600',
                    bgColor: '#2980B9',
                    textColor: 'white'
                });
                
                setTimeout(()=>{
                    window.location.href="order-history.php";
                },1500);
            } else {
                // $('.show-msg').html('<p class="alert alert-info">Failed to insert data.</p>');
                $.toast({
                    text: "Failed to add order", 
                    heading: 'Error', 
                    icon: 'error',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 1700,
                    stack: 5, 
                    position: 'mid-center',          
                    textAlign: 'center', 
                    loader: true, 
                    loaderBg: '#9EC600',
                    bgColor: '#2980B9',
                    textColor: 'white'
                });
            }
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            $('.catContainer').html('<p>An error occurred while fetching data. Please try again later.</p>');
        }
    });
}

</script>
<script>
    function cartUpdate(action, proid, element) {
        let qty = 0;

        // Use closest() and find() to locate the quantity input
        let quantityInput = $(element).siblings('.quantity-input');

        if (quantityInput.length) {
            qty = parseInt(quantityInput.val()) || 0;

            // Adjust quantity based on action
            if (action === 'plus') {
                qty += 1; // Increase quantity
            } else if (action === 'minus') {
                qty = Math.max(qty - 1, 0); // Decrease quantity, ensure it doesn't go below 0
            }
            $('#qty'+proid).val(qty)
        }


        // Update the quantity in the AJAX request
        $.ajax({
            url: "update-cart.php",
            type: "POST",
            data: {
                pro_id: proid,
                qty: qty
            },
            success: function(response) {
                let res=JSON.parse(response);

                if(res.status==200)
                {
                    $("#total-price").text(res.amount);
                }
                else
                {
                    $('.show-msg').html(res.msg);
                }
            },
            error: function(xhr, status, error) {
                $('.show-msg').html(error);
                // console.error("Error updating cart:", error);
            }
        });
    }
</script>
<script>
    function removeCart(proid) {
        // Update the quantity in the AJAX request
        $.ajax({
            url: "delete-cart.php",
            type: "POST",
            data: {
                pro_id: proid
            },
            success: function(response) {
                let res=JSON.parse(response);
                if(res.status==200)
                {
                    $("#item-cart"+proid).remove();
                    $("#total-price").text(res.amount);
                    if(res.amount==0){
                        $("#checkout-btn").hide();
                    }
                    $.toast({
                        text: 'Item removed from cart', 
                        heading: 'Information', 
                        icon: 'success',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 1700,
                        stack: 5, 
                        position: 'mid-center',          
                        textAlign: 'center', 
                        loader: true, 
                        loaderBg: '#9EC600',
                        bgColor: '#2980B9',
                        textColor: 'white'
                    });
                }else{
                    $.toast({
                        text: res.msg, 
                        heading: 'Error', 
                        icon: 'error',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 1700,
                        stack: 5, 
                        position: 'mid-center',          
                        textAlign: 'center', 
                        loader: true, 
                        loaderBg: '#9EC600',
                        bgColor: '#2980B9',
                        textColor: 'white'
                    });
                }

            },
            error: function(xhr, status, error) {
                $('.show-msg').html(error);
                // console.error("Error updating cart:", error);
            }
        });
    }
</script>
