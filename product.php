<?php
session_start();
if(!isset($_COOKIE['mobile']))
{
    echo '<script>window.location.href="login.php"</script>';
}
?>

<?php include "header.php" ?>

<?php
$cat_id=$_GET['id'];
$sel_products = $obj->fetch("SELECT * FROM items WHERE cat_id='$cat_id'");
?>

<style>
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 300px; /* Fixed height for each card */
    display: flex;
    flex-direction: column;
    align-items: center; /* Center content horizontally */
}

.card-img-top {
    height: 210px;
    object-fit: contain;
    margin:0 auto;
}

.card-body {
    padding: 1rem;
    text-align: center; /* Center-align text */
}

.card-title {
    font-size: 16px;
    /*font-weight: bold;*/
    margin: 0; /* Remove margin to fit neatly */
}

.card-status {
    color: #fff;
    padding: 0.5rem;
    text-align: center;
    /* font-weight: bold; */
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    border-bottom: 1px solid #fff;
    font-size: 14px;
}

.not-avl{
    background-color: #ff7676;
}
.avl{
    background-color: #28a745;
}

.card-container {
    margin-top: 50px;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.row>* {
        width: 45% !important;
    height: auto !important;
}

</style>

<div class="container card-container">
    <div class="row justify-content-center">
        <?php
        
        foreach($sel_products as $val_products){
            $image=json_decode($val_products['image_url']);
            if($image){
                foreach($image as $pro_val)
                {
                     $pro_img_array[]=str_replace('../', '', $pro_val->image);
                }
            
                $pro_img_array=array_reverse($pro_img_array);
            }else{
                $pro_img_array=[];
            }
            
            $status = "Available"; // You can dynamically set the status here
        ?>
        <div class="col-md-6 col-lg-4 mb-2" onclick="handleProductClick(<?=$val_products['id']?>)">
            <div class="card position-relative">
                <div class="card-status <?=($val_products['status']=='Available'?'avl':'not-avl')?>"><?=$val_products['status']?></div>
                <img src="../<?=$pro_img_array[0]?>" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title"><?=$val_products['name']?></h5>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>



<?php include "footer.php" ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function handleProductClick(id){
        window.location.href=`product-details.php?id=${id}`;
    }
</script>