<?php include "header.php" ?>
<style>
    .card{
        background-color:transparent !important;
    }
    /*.card{*/
    /*    background-color:#000;*/
    /*}*/
    .card-img-top{
        background-color:transparent !important;
    }
    /*.card-body{*/
    /*background-color: #fff;*/
    /*padding: 2px;*/
    /*border-bottom-right-radius: 5px;*/
    /*border-bottom-left-radius: 5px;*/
    /*}*/
    .card-body {
        background-color: #5c5757;
        padding: 2px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        color: #fff;
    }
</style>
<div class="container catContainer mt-4">
    <div class="row">
        <!-- Dynamic content will be injected here -->
        <?php
        $cat_data=$obj->fetch("SELECT * FROM category ORDER BY name ASC");
        foreach($cat_data as $val){
        ?>
        
        <div class="col-md-4 mb-4 col-6" onclick="handleCategoryClick(<?=$val['id']?>)" style="cursor:pointer;padding:0px 24px 0px 24px;">
            <div class="card">
                <img src="<?= $val['image'] ?>" class="card-img-top" alt="<?= $val['name'] ?>">
                <div class="card-body">
                    <p class="card-text text-center"><?= $val['name'] ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>


<?php include "footer.php" ?>

<script>
    function handleCategoryClick(id){
        window.location.href=`product.php?id=${id}`;
    }
</script>
