<?php
function getIndividualPrice($obj, $user_id, $pro_id, $cat_id, $user_type) {
    // Try to get price for specific product
    $query = "SELECT set_price FROM individual_price 
              WHERE category = '$cat_id' AND product_id = '$pro_id' 
              AND user_type = '$user_type' AND user_id = '$user_id'";
    $price = $obj->arr($query);
    
    // If a specific product price is not set, try for 'All' products
    if (empty($price['set_price'])) {
        $query = "SELECT set_price FROM individual_price 
                  WHERE category = '$cat_id' AND product_id = 'All' 
                  AND user_type = '$user_type' AND user_id = '$user_id'";
        $price = $obj->arr($query);
    }
    
    return $price['set_price'] ?? null;
}

function checkPrice($obj, $user_id, $pro_id, $cat_id, $user_type) {
    // Check for individual price for specific user
    $userExists = $obj->num("SELECT id FROM individual_price WHERE user_type = '$user_type' AND user_id = '$user_id'");
    
    if ($userExists > 0) {
        $price = getIndividualPrice($obj, $user_id, $pro_id, $cat_id, $user_type);
        if ($price !== null) {
            return $price;
        }
    }
    
    // Check for 'All' users
    $allUserExists = $obj->num("SELECT id FROM individual_price WHERE user_type = '$user_type' AND user_id = 'All'");
    
    if ($allUserExists > 0) {
        $price = getIndividualPrice($obj, 'All', $pro_id, $cat_id, $user_type);
        if ($price !== null) {
            return $price;
        }
    }
    
    // Fallback to general product price
    $sel_product = $obj->arr("SELECT price FROM items WHERE id = '$pro_id'");
    return $sel_product['price'] ?? null;
}


function convert_filesize($bytes, $decimals = 2)
{
    $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

// Function to compress the image and return as base64 string
function compressImage($source, $quality)
{
    // Get image info 
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    // Create a new image from file 
    ob_start(); // Start output buffering
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, null, $quality); // Output image to buffer
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            imagepng($image, null, $quality / 10); // Output image to buffer
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            imagegif($image); // Output image to buffer
            break;
        default:
            return false; // Invalid image format
    }
    $compressedImageData = ob_get_clean(); // Get image data from buffer

    // Return compressed image data as base64 string
    return 'data:' . $mime . ';base64,' . base64_encode($compressedImageData);
}

?>