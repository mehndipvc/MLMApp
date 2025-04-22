<?php
include("config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

$data = array();

$cat_data = $obj->fetch("SELECT id,category,image_path FROM gal_category");

foreach ($cat_data as $fet_val) {
    
    $data[] = array(
        'cat_id' => $fet_val['id'],
        'category' => $fet_val['category'],
        'image' => $fet_val['image_path']
    );
    
}

$response = array(
    'data' => $data
);

echo json_encode($response, JSON_PRETTY_PRINT);
?>
