<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: POST');
//  header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
//  header("Cache-Control: no-cache, no-store, must-revalidate");
// header("Pragma: no-cache");
// header("Expires: 0");

include('dbcon.php');
include('common_functions.php');

// print_r('aa');
// exit();

if(!empty($_POST['cat_id']))
{
   $cat_id=$_POST['cat_id'];
    $user_id=$_POST['user_id'];
     $query = "SELECT * FROM items WHERE cat_id='$cat_id'";
    $query_run = mysqli_query($conn,$query);
    if($query_run)
    {
        // $res = mysqli_fetch_array($query_run);
        // echo(json_encode($res, JSON_PRETTY_PRINT));
        
        $arr=[];
        
        while($row=mysqli_fetch_assoc($query_run))
        {
            $price='';
            $pro_id=$row['id'];
            $pro_img_array=array();
            $pro_image=json_decode($row['image_url']);
            foreach($pro_image as $pro_val)
            {
                 $pro_img_array[]=str_replace('../', '', $pro_val->image);
            }
            $pro_img_array=array_reverse($pro_img_array);
            
            $query_indv = "SELECT product_id,set_price FROM individual_price WHERE category='$cat_id' AND user_id='$user_id'";
            $query_run_indv = mysqli_query($conn, $query_indv);
            
            $indv = array();
            
            while ($row1 = mysqli_fetch_assoc($query_run_indv)) {

                if($row1['product_id']!='All Products'){
                    $product_ids = explode(',', $row1['product_id']);
                
                    foreach ($product_ids as $product_id) {
                        $indv[] = array(
                            'product_id' => $product_id,
                            'set_price' => $row1['set_price']
                        );
                    }
                }else{
                    $indv[] = array(
                            'product_id' => $pro_id,
                            'set_price' => $row1['set_price']
                        );
                }
            }
            
            foreach ($indv as $indv_val) {
                if($indv_val['product_id']==$pro_id){
                    $price=$indv_val['set_price'];
                }
            }
            
            
       
           // $price = mysqli_fetch_assoc($query_run_indv)['set_price'];
            
            if($price==''){
                $price=$row['price'];
            }
            
            $arr[]=array(
                    "id"=>$row['id'],
                    "cat_id"=>$row['cat_id'],
                    "name"=>$row['name'],
                    "code"=>$row['code'],
                    "price"=>$price,
                    "quantity"=>$row['quantity'],
                    "about"=>strip_tags($row['about']),
                    "features"=>strip_tags($row['features']),
                    "status"=>$row['status'],
                    "image"=>$pro_img_array
                );
                
        }
        if(!empty($arr))
        {
            // $json = json_encode($arr, JSON_PRETTY_PRINT);
            // // Check for JSON encoding errors
            // if (json_last_error() === JSON_ERROR_NONE) {
            //     echo $json;
            // } else {
            //     echo 'JSON encoding error: ' . json_last_error_msg();
            // }
            
            function utf8_encode_deep($data) {
                if (is_array($data)) {
                    return array_map('utf8_encode_deep', $data);
                } elseif (is_string($data)) {
                    return mb_convert_encoding($data, 'UTF-8', 'auto');
                } else {
                    return $data;
                }
            }
            
            $arr = utf8_encode_deep($arr);
            
            $json = json_encode($arr, JSON_PRETTY_PRINT);

            // Check for JSON encoding errors
            if (json_last_error() === JSON_ERROR_NONE) {
                echo $json;
            } else {
                echo 'JSON encoding error: ' . json_last_error_msg();
            }
            
            
        }
       
    }
    else
    {
        echo 'conncetion error';
    }
    
}
else
{
    echo "Inavlid parameter";
}

?>