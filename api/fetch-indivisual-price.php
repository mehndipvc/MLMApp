<?php
include("config.php");

if (!empty($_POST['user_id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $temp_user_id = $_POST['user_id'];
    $orders_data = [];

    function fetchData($parent_id, $id, $obj, $temp_user_id, &$orders_data)
    {
        $user_data = $obj->fetch("SELECT id, user_id, name, mobile, email, parent_id FROM users WHERE parent_id='$parent_id'");

        if ($user_data) {
            foreach ($user_data as $user_val) {
                $child_user_id = $user_val['user_id'];
                $child_id = $user_val['id'];

                $order = $obj->fetch("SELECT title,date, product_id, user_id, order_id, name,order_quantity,temp_path FROM orders WHERE user_id='$child_user_id' AND status='Confirmed'");
                if (!empty($order)) {
                    foreach ($order as $order_val) {
                        $product_id = explode(',', $order_val['product_id']);
                        $order_quantity=explode(',',$order_val['order_quantity']);
                        $temp_path=$order_val['temp_path'];
                        $ch_id=$order_val['user_id'];
                  
                        $indv_data = $obj->fetch("SELECT * FROM individual_price WHERE user_id='$ch_id'");
                        
                        foreach ($indv_data as $indv_val) {
                            $amount=0;
                            
                            if($indv_val['product_id']=='All Products'){
                                $cat_id=$indv_val['category'];
                                $sel_pro_ids=$obj->fetch("SELECT id FROM items WHERE cat_id='$cat_id'");
                                
                                $idArray = array();

                                foreach ($sel_pro_ids as $nestedArray) {
                                    if (isset($nestedArray['id'])) {
                                        $idArray[] = $nestedArray['id'];
                                    }
                                }

                                $product_id_indv = $idArray;
                            }else{
                                $product_id_indv = explode(',', $indv_val['product_id']);
                            }
                            //echo $indv_val['product_id'] . " ";
                            
                            //   print_r($product_id_indv);
                            //   echo " ";
                              
                              $pro_count=count((array) $product_id);
                              for($i=0;$i<$pro_count;$i++)
                              {
                                  
                                 if (in_array($product_id[$i], $product_id_indv)) {
                                    //  print_r($indv_val);
                                    // echo " ";
                                    $amount = $amount+$indv_val['price']*$order_quantity[$i];
                                    
                                }
                                
                              }
                              
                              $altUserId=$order_val['user_id'];
                              
                              $getData=$obj->arr("SELECT id FROM users WHERE user_id='$altUserId'");
                              
                              $orders_data[] = array(
                                  'id' => $getData['id'],
                                        'user_id' => $order_val['user_id'],
                                        'order_id' => $order_val['order_id'],
                                        'date' => $order_val['date'],
                                        'name' => $order_val['name'],
                                        'earning_amount' => $amount,
                                        'invoice_path'=>$temp_path
                                    );
                                
                            
                            
                            
                        }
                    }
                }

                fetchData($child_id, $child_user_id, $obj, $temp_user_id, $orders_data);
            }
        }
    }

    fetchData($id, $user_id, $obj, $temp_user_id, $orders_data);
   //echo json_encode($orders_data,JSON_PRETTY_PRINT);
    
    $filtered_orders_data = array_filter($orders_data, function ($item) {
        return $item['earning_amount'] != 0;
    });
    $consolidated_orders_data = [];
    foreach ($filtered_orders_data as $order) {
        $order_id = $order['order_id'];
        if (!isset($consolidated_orders_data[$order_id])) {
            $consolidated_orders_data[$order_id] = $order;
        } else {
            $consolidated_orders_data[$order_id]['earning_amount'] += $order['earning_amount'];
        }
    }
    $consolidated_orders_data = array_values($consolidated_orders_data);
    echo json_encode($consolidated_orders_data, JSON_PRETTY_PRINT);

}else{
    echo json_encode('Id or User id is Empty....!!');
}
?>
