<?php
include("config.php");
$fetch = $obj->fetch("SELECT * FROM gal_category");

$data = array();

foreach ($fetch as $fet_val) {
    $cat_id = $fet_val['id'];
    
    // $cat_data=$obj->arr("SELECT filename FROM items_images WHERE cat_id='$cat_id'");
    // $data[]=array(
    //     'image'=>$cat_data['filename'],
    //     'category'=>$fet_val['category'],
    //     'cat_id'=>$fet_val['id'],
    // );

    $cat_data = $obj->fetch("SELECT filename FROM items_images WHERE cat_id='$cat_id' ORDER BY id desc");
    
    if (!empty($cat_data)) {
        $images = array();
        $firstImage = $cat_data[0]['filename'];

        foreach ($cat_data as $cat_val) {
            $images[] = $cat_val['filename'];
        }
        // $images=array_reverse($images);
        $data[] = array(
            'cat_id' => $fet_val['id'],
            'category' => $fet_val['category'],
            'image' => $fet_val['image_path'],
            'images' => $images,
        );
    }
}

print_r(json_encode($data, JSON_PRETTY_PRINT));
?>
