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
$sel_user=$obj->arr("SELECT name FROM users WHERE user_id='$user_id'");
?>

<style>
.offer-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #e74c3c;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
}

.product-card {
    position: relative;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    height:250px;
}

.product-image {
    height: 100%;
    width: 70%;
    object-fit:contain;
    margin:0 auto;
}

.original-price {
    text-decoration: line-through;
    color: #999;
}
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Product Card 1 -->
        <?php
        $sel_offer=$obj->fetch("SELECT * FROM discounts ORDER BY id DESC");
        foreach($sel_offer as $val_offer){
            $pro_id=$val_offer['item_id'];
            $sel_product=$obj->arr("SELECT name,image_url,features,price FROM items WHERE id='$pro_id'");
            $name=$sel_product['name'];
            
            $image=json_decode($sel_product['image_url']);
            foreach($image as $pro_val)
            {
                 $pro_img_array[]=str_replace('../../', '', $pro_val->image);
            }
            $pro_img_array=array_reverse($pro_img_array);
            
        ?>
        <div class="col-md-4">
            <div class="product-card card">
                <div class="offer-badge">
                <?php
                $revised_amt=$sel_product['price'];
                if($val_offer['discount_type']=='Percentage'){
                    $revised_amt=$revised_amt-($revised_amt*($val_offer['amount']/100))
                ?>
                <?=$val_offer['amount']?>% OFF
                <?php }else{
                $revised_amt=$revised_amt-$val_offer['amount'];
                ?>
                <span style="font-family:calibri;">₹ </span> <?=$val_offer['amount']?> OFF
                <?php } ?>
                </div>
                <img src="<?=$pro_img_array[0]?>" class="card-img-top product-image" alt="Product Image 1">
                <div class="card-body text-center">
                    <h5 class="card-title" style="position:fixed;"><?=$name?></h5>
                    
                    
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
</div>


<?php include "footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
