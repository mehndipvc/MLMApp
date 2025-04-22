<?php
include('config.php');
include('common_functions.php');

$sel_user=$obj->fetch("SELECT * FROM users");

// print_r($sel_user);
// exit;

// function generateTreeView($users, $parentId = 0) {
//     $tree = [];
//     foreach ($users as $user) {
//         if ($user['parent_id'] == $parentId) {
//             $node = [
//                 'id' => $user['id'],
//                 'parent_id' => $user['parent_id'],

//                 'name' => $user['name'],
//                 'childs' => generateTreeView($users, $user['id'])
//             ];
//             $tree[] = $node;
//         }
//     }
//     return $tree;
// }

// $treeView = generateTreeView($sel_user);

// $treeViewJson = json_encode($treeView, JSON_PRETTY_PRINT);

// echo $treeViewJson;
//print_r($treeView);

function generateTreeView($users, $userId) {
    $tree = [];
    foreach ($users as $user) {
        if ($user['parent_id'] == $userId) {
            $node = [
                'id' => $user['id'],
                'user_id' => $user['user_id'],
                'parent_id' => $user['parent_id'],
                'name' => $user['name'],
                'user_type' => $user['user_type'],
                'childs' => generateTreeView($users, $user['id'])
            ];
            $tree[] = $node;
        }
    }
    return $tree;
}

function findUserIndexById($users, $userId) {
    foreach ($users as $index => $user) {
        if ($user['id'] == $userId) {
            return $index;
        }
    }
    return -1;
}

function generateTreeViewById($users, $userId) {
    $userIndex = findUserIndexById($users, $userId);
    if ($userIndex !== -1) {
        return generateTreeView($users, $users[$userIndex]['id']);
    } else {
        return [];
    }
}
if(!empty($_GET['user_id'])){
    $userId = $_GET['user_id'];
    $treeView = generateTreeViewById($sel_user, $userId);
    
    if (!empty($treeView)) {
        $treeViewJson = json_encode($treeView, JSON_PRETTY_PRINT);
        echo $treeViewJson;
    } else {
        $response = array(
            "message" => "No children present",
            "code" => 400
        );
        echo json_encode($response);
    }

}else{
    $response = array(
        "error" => array(
            "message" => "User ID is missing",
            "code" => 400
        )
    );
    echo json_encode($response);
}

?>