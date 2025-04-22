<?php
include("config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");







$data = array();

$cat_id = $_GET['cat_id'];
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = isset($_GET['item']) ? intval($_GET['item']) : 10; // Default value if 'item' is not set
$offset = ($page - 1) * $items_per_page;

// Fetch the total count of records
$total_items_result = $obj->fetch("SELECT COUNT(*) as count FROM items_images WHERE cat_id='$cat_id' AND status='Approve'");
$total_items = $total_items_result[0]['count'];
$total_pages = ceil($total_items / $items_per_page);

// Fetch the actual data for the current page
$cat_data = $obj->fetch("SELECT * FROM items_images WHERE cat_id='$cat_id' AND status='Approve' ORDER BY id DESC LIMIT $offset, $items_per_page");

foreach ($cat_data as $fet_val) {
    $fetchCat = $obj->arr("SELECT category FROM gal_category WHERE id='$cat_id'");
    $filename = $fet_val['filename'];

    $data[] = array(
        'id'=>$fet_val['id'],
        'cat_id' => $cat_id,
        'category' => $fetchCat['category'],
        'image' => $filename,
    );
}

$response = array(
    'data' => $data,
    'total_pages' => $total_pages,
    'current_page' => $page
);




echo json_encode($response, JSON_PRETTY_PRINT);
?>
