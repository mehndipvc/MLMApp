<?php

include("api/config.php");


    $name = $_POST['name'] ?? '';
    $company = $_POST['company'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $created_by = $_COOKIE['user_id'];
    $cr_date = date('d-m-Y');
    
    // Validate required fields
    if (empty($name) || empty($mobile) || empty($address)) {
        echo '<p class="alert alert-warning">Please fillup mendatory fields!</p>';
        exit;
    }
    
    if (!preg_match('/^\d{10}$/', $mobile)) {
        echo '<p class="alert alert-warning">Invalid Mobile Number!</p>';
        exit;
    }
    // Check Duplicate Mobile or Email
    
    
    if($email==''){
        $sel_duplicate=$obj->num("SELECT id FROM leads WHERE mobile='$mobile'");
        $sel_duplicate_user=$obj->num("SELECT id FROM users WHERE mobile='$mobile'");
        if ($sel_duplicate>0 || $sel_duplicate_user>0) {
            $sel_parent=$obj->arr("SELECT parent_id FROM users WHERE mobile='$mobile'");
            $par_id=$sel_parent['parent_id'];
            $sel_parent=$obj->arr("SELECT name FROM users WHERE id='$par_id'");
            $parent_name = $sel_parent['name'];
            echo '<p class="alert alert-warning">These details are already used by ' . htmlspecialchars($parent_name) . '....!</p>';
            exit;
        }
    }else{
        $sel_duplicate=$obj->num("SELECT id FROM leads WHERE mobile='$mobile' OR email='$email'");
        $sel_duplicate_user=$obj->num("SELECT id FROM users WHERE mobile='$mobile' OR email='$email'");
        if ($sel_duplicate>0 || $sel_duplicate_user>0) {
            $sel_parent=$obj->arr("SELECT parent_id FROM users WHERE mobile='$mobile' OR email='$email'");
            $par_id=$sel_parent['parent_id'];
            $sel_parent=$obj->arr("SELECT name FROM users WHERE id='$par_id'");
            $parent_name = $sel_parent['name'];
            echo '<p class="alert alert-warning">These details are already used by ' . htmlspecialchars($parent_name) . '....!</p>';
            exit;
        }
    }
    $folder='';
    if(!empty($_FILES['image']['name'])){
        $file = $_FILES['image'];
        $allowed = array('png', 'jpg', 'jpeg', 'webp');
        $doc = $file['name'];
        $ext = pathinfo($doc, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            echo '<p class="alert alert-warning">Invalid file format. Allowed formats: '.implode(', ', $allowed).'</p>';
            exit;
        }
        $tmp = $file['tmp_name'];
        $temp = explode(".", $doc);
        $newfile = rand(1000000000000, 9999999999999) . '.' . end($temp);
        $folder = "../api/assets/" . $newfile;
    
        move_uploaded_file($tmp, $folder);
    }
    
    $sel_last=$obj->arr("SELECT user_id FROM users ORDER BY id DESC");
    $user_id=$sel_last['user_id']+1;

    // Prepare SQL query
    $sql = $obj->query("INSERT INTO `leads`(`name`, `company`, `mobile`, `email`, `address`, `created_by`, `cr_date`,`image`,`user_id`) 
            VALUES ('$name', '$company', '$mobile', '$email', '$address', '$created_by', '$cr_date','$folder','$user_id')");
    
    $sel_parent=$obj->arr("SELECT id FROM users WHERE user_id='$created_by'");
    $parent=$sel_parent['id'];
    
    $ins_item=$obj->query("INSERT INTO users(user_id,user_type,password,name,parent_id,mobile,email,address) 
    values ('$user_id','Customer','$mobile','$name','$parent','$mobile','$email','$address')");
    

    // Execute the query and handle errors
    if ($sql) {
        
        echo 200;
    } else {
        echo '<p class="alert alert-warning">Error while submit</p>';
    }

?>
