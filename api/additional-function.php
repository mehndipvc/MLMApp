<?php
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