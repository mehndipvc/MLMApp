<?php
include("dbcon.php");
if(!empty($_POST['id']) && !empty($_POST['user_id']))
{
    $id=$_POST['id'];
    $user_id=$_POST['user_id'];
    
    
    
    $query = "SELECT price FROM individual_price WHERE user_id='$user_id'";
        $query_run = mysqli_query($conn,$query);
        if($query_run){
            
            $val=mysqli_fetch_assoc($query_run);
            $amount=$val['price'];
             $user_data_query="SELECT user_id,name,mobile,email FROM users WHERE parent_id='$id'";
            $query_exe = mysqli_query($conn,$user_data_query);
           
            while($row=mysqli_fetch_assoc($query_exe))
            {
                $child_user_id=$row['user_id'];
                 $user_data_qry="SELECT title FROM orders WHERE user_id='$child_user_id' AND status='Confirmed'";
                $query_execute = mysqli_query($conn,$user_data_qry);
                //$row_data=mysqli_fetch_array($query_execute);
                $arr=[];
                while($row_data=mysqli_fetch_assoc($query_execute))
                {
                    $arr[]=array(
                            "name"=>$row['name'],
                            "email"=>$row['email'],
                            "mobile"=>$row['mobile'],
                            "amount"=>$amount,
                            "product_name"=>$row_data['title']
                        );
                }
                if(!empty($arr))
                {
                    echo(json_encode($arr,JSON_PRETTY_PRINT)); 
                }
            }
          
        }
        else
        {
            echo "No record found";
        }
}
else
{
    echo "Invalid Parameter";
}

?>
