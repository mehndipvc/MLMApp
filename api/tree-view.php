<?php

// Database connection parameters
$servername = "localhost";
$username = "u439213217_mehndi_pro23";
$password = "Mehndi@2023$#";
$dbname = "u439213217_mehndi_pro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data_array = array();

function generateTree($parent_id = 0)
{
    global $conn, $data_array;

    $sql = "SELECT id, name, user_type, parent_id, user_id FROM users WHERE parent_id = $parent_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            $userType = $row['user_type'];

            $item = array(
                "name" => $name,
                "user_type" => $userType
            );

            $data_array[] = $item;

            generateTree($id);
        }
    }
}

if (!empty($_POST['user_id'])) {
    $userID = $_POST['user_id'];

    generateTree($userID);

    echo json_encode($data_array);
}

$conn->close();
?>
