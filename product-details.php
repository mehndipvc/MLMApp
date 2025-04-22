<?php
session_start();

if (!isset($_COOKIE['mobile'])) {
    echo '<script>window.location.href="login.php"</script>';
}
$user_id = $_COOKIE['user_id'];
$user_type= $_COOKIE['user_type'];
?>

<?php include "header.php" ?>

<?php
include('additional-functions.php');
$pro_id = $_GET['id'];
$sel_product = $obj->arr("SELECT * FROM items WHERE id='$pro_id'");

$price = checkPrice($obj, $user_id, $pro_id, $sel_product['cat_id'],$user_type);
?>

<style>
    .product-carousel img {
        /*height: 120px;*/
        /*object-fit: cover;*/
    }

    .product-details {
        margin-top: 20px;
    }

    .product-title {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .product-code {
        color: #6c757d;
        font-size: 14px;
    }

    .product-description {
        margin-top: 20px;
        font-size: 13px;
        color: #555;
    }
    
    .product-description p{
        font-size: 14px;
    }

    .product-info {
        font-size: 1rem;
        color: #333;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #7a000d;
    }

    .btn-add-to-cart {
    background-color: #7a000d;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    margin: 10px;
    transition: background-color 0.3s;
}

    .btn-add-to-cart:hover {
        background-color: #000;
        color: #fff;
    }
     .btn-add-to-cart:active {
        background-color: #000;
        color: #fff;
    }

    .product-container {
        margin-top: 10px;
    }
/*.owl-carousel .item img {*/
/*    height:auto !important;*/
/*}*/
.feature-text{
    font-size:13px;
}

.price-section {
    display: flex;
    justify-content: space-around;
    position: fixed;
    top: 89vh;
    left: 0;
    bottom: 0;
    background-color: #f2e1e1;
    width: 100%;
    align-items: center;
    gap: 50px;
}
.owl-carousel .item img {
    display: block;
    width: 100px;
    /*height: 15rem;*/
    /*object-fit: cover;*/
}   
.owl-carousel .item {
    background: #fff;
}
table
{
    width:100% !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<div class="container product-container">
    <div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div id="productCarousel" class="owl-carousel owl-theme product-carousel">
                    <?php
                    $text = base64_decode($sel_product['features']);
                    
                    $image = json_decode($sel_product['image_url']);
                    if($image){
                        foreach ($image as $pro_val) {
                            $pro_img_array[] = str_replace('../', '', $pro_val->image);
                        }
                        $pro_img_array = array_reverse($pro_img_array);
                    }else{
                        $pro_img_array =[];
                    }
                    foreach ($pro_img_array as $index => $image) {
                        echo "<div class='item'>";
                        echo "<a href='../{$image}' data-fancybox='gallery' data-caption='Product Image " . ($index + 1) . "'>";
                        echo "<img src='../{$image}' class='d-block card-img-top' alt='Product Image " . ($index + 1) . "'>";
                        echo "</a>";
                        echo "</div>";
                    }
                    ?>
                </div>

                </div>
            </div>
            <!-- Image Carousel -->
        
        </div>
        <div class="col-lg-6">
            <!-- Product Details -->
            <div class="card mt-3" style="margin-bottom: 90px;">
                <div class="product-details card-body">
                    <div class="text-end">
                        <?php
                        if($sel_product['status']=='Available'){
                        ?>
                        <span class="badge bg-success"><?= $sel_product['status'] ?></span>
                        <?php }else{ ?>
                        <span class="badge bg-danger"><?= $sel_product['status'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="product-title">Item Code: </div>
                    <div class="product-title"><?= $sel_product['name'] ?></div>
                    <div class="product-description">
                        <p class="feature-text"><?= $text ?></p>
                    </div>
                    
                    <div class="product-info">
                        <h6>Details:</h6>
                        <ul style="font-size:12px;">
                            <?= base64_decode($sel_product['about']) ?>
                        </ul>
                    </div>
                    
                    <div class="price-section">
                        <div class="price"><span style="font-family:calibri;">₹</span> <?= $price ?></div>

                        <input type="hidden" id="pro_id" value="<?= $pro_id ?>">
                        <input type="hidden" id="price" value="<?= $price ?>">
                        <input type="hidden" id="pro_image" value="<?= $pro_img_array[0] ?>">
                        <?php
                        if($price>0 && $sel_product['status']=='Available'){
                        ?>
                            <button class="btn btn-add-to-cart" onclick="addtocart()">Add to Cart</button>
                        <?php }else{ ?>
                            <button class="btn btn-add-to-cart" onclick="cartEmpty()">Add to Cart</button>
                        <?php } ?>
                    </div>
                    
                </div>
                <div class="show-msg mt-2"></div>
            </div>

        </div>
    </div>
</div>

<?php include "footer.php" ?>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    function cartEmpty(){
        
        $.toast({
            text: "Product is not available", 
            heading: 'Information', 
            icon: 'error',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 1700,
            stack: 5, 
            position: 'mid-center',          
            textAlign: 'center', 
            loader: true, 
            loaderBg: '#9EC600',
            bgColor: '#ee3f23',
            textColor: 'white'
        });
        
    }

    function addtocart() {

        const itemData = {
            pro_id: $('#pro_id').val(),
            price: $('#price').val(),
            image_url: $('#pro_image').val(),
        };

        $.ajax({
            url: "add-to-cart.php",
            type: "post",
            data: {
                pro_id: itemData.pro_id,
                price: itemData.price,
                image_url: itemData.image_url
            },
            beforeSend: function() {
                $('.btn-add-to-cart').html('Processing...');
            },
            success: function(response) {

                $('.btn-add-to-cart').html('Add to Cart');
                if (response == 200) {
                    //$('.show-msg').html('<p class="alert alert-info">Added to Cart Successfully.</p>');
                    
                    $.toast({
                        text: "Added to Cart Successfully", 
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
                    
                    // setTimeout(()=>{
                    //     window.location.href = "view-cart.php";
                    // },1500)
                    
                } else {
                    // console.log('Failed to insert data.');
                    // $('.show-msg').html(response);
                    $.toast({
                        text: response, 
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
                setTimeout(() => {
                    $('.show-msg').html('');
                }, 1500)
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>
<script>
    $(document).ready(function(){
  $("#productCarousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      items: 1, // Show one item at a time
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true
  });
});

</script>