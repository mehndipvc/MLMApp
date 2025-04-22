<?php
include("config.php");
include("add-watermark.php");
session_start();

if (!empty($_POST['cat_id']) && !empty($_FILES['image']['name']) && !empty($_COOKIE['user_id'])) {
    $cat_id = $_POST['cat_id'];
    $user_id = $_COOKIE['user_id'];
    $file = $_FILES['image'];
    $allowed = array('png', 'jpg', 'jpeg', 'webp');

    // Validate file type
    $doc = $file['name'];
    $ext = pathinfo($doc, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
        echo "Invalid file format. Allowed formats: " . implode(', ', $allowed);
        exit;
    }

    // Process the file
    $tmp = $file['tmp_name'];
    $temp = explode(".", $doc);
    $newfile = rand(1000000000000, 9999999999999) . '.' . end($temp);
    $folder = "../api/assets/" . $newfile;

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($tmp, $folder)) {
        $filename = $newfile;
        $gallery_code = rand(10000, 99999);
        $item_id = rand(0000000000000, 9999999999999);
        // Construct the SQL query
        $query = "INSERT INTO items_images (gallery_code, filename, user_id, cat_id,item_id,status) VALUES ('$gallery_code', '$filename', '$user_id', '$cat_id','$item_id','Pending')";

        // Execute the query
        if ($obj->query($query)) {
            addWatermark($folder);
            echo 200;
        } else {
            echo '<p class="alert alert-danger">Error: Something went wrong with the database!</p>';
        }
    } else {
        echo "Failed to upload file: " . $doc;
    }
} else {
    echo '<p class="alert alert-danger">Please fill out all mandatory fields.</p>';
}
?>
