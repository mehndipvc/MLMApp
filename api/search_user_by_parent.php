<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: POST');
 header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbcon.php');include('common_functions.php');

$parent=$_POST['parent'];
return getData($parent);


function getData($parent){
    global $conn;
    
    // $query="SELECT * FROM users WHERE parent= $parent";
    
    $query = "SELECT
  users.user_id,
  users.name,
  users.email,
  users.mobile,
  COALESCE(SUM(orders.price), 0) AS total_orders_price,
  COALESCE(SUM(items.price), 0) AS total_items_price,
  COALESCE(SUM(orders.price), 0) + COALESCE(SUM(items.price), 0) AS total_price
FROM
  users
LEFT JOIN
  orders ON users.user_id = orders.user_id
LEFT JOIN
  order_item ON orders.order_id = order_item.order_id
LEFT JOIN
  items ON order_item.item_id = items.item_id
WHERE
  users.parent = '$parent'
GROUP BY
  users.user_id,
  users.name,
  users.email,
  users.mobile;";
    
    $query_run = mysqli_query($conn,$query);
    if($query_run){
        if(mysqli_num_rows($query_run)>0){
            $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            echo myResponseWithData(200,$res);
        }else{
            echo myResponseNoData(204);
        }
    }else{
        echo myResponseNoData(405);
    }
}



?>