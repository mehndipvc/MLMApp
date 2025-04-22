<?php

include('config.php');

if(!empty($_POST['user_id']) && !empty($_POST['amount'])){
    $user_id=$_POST['user_id'];
    $amount=$_POST['amount'];
    $date=date('Y-d-m');
    
    $query_ins=$obj->query("INSERT INTO `withdraw`(`user_id`, `amount`, `cr_date`, `status`) VALUES ('$user_id','$amount','$date','Pending')");
    
    if($query_ins){
        echo 200;
    }else{
         echo '<p class="alert alert-warning">Error while submit</p>';
    }
    

}else{
    echo '<p class="alert alert-warning">Please Enter Amount</p>';
}

?>