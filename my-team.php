
<?php
session_start();
if(empty($_COOKIE['id']))
{
   header("location:index.php"); 
   exit;
}
$uid=$_COOKIE['id'];
// Database connection parameters
$servername = "localhost";
$username = "mehndipvc_u439213217_mehndi_pro2";
$password = "Mehndi@2023$#";
$dbname = "mehndipvc_u439213217_mehndi_pro";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateTree($parent_id = 0, $isSubparent = false) {
    global $conn;

    // Fetch data from the database
    $sql = "SELECT * FROM users WHERE parent_id = $parent_id ORDER BY name ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<ul>';
       
        while ($row = $result->fetch_assoc()) {
            $user_type = $row['user_type'];
            $user_name = htmlspecialchars($row['name']);
            // if($user_type=='Customer')
            // {
            //     $maxLength = 4;
            // }
            // else
            // {
            //     $maxLength = 10;
            // }
            
            // if (strlen($user_name) > $maxLength) {
            //     $user_name = substr($user_name, 0, $maxLength) . '...';
            // }
            
            echo '<li>
                    <div class="userbtn ' . $user_type . '">
                        <span>' . $user_name . '</span>
                        <small style="font-size:10px;"> (' . $user_type . ')</small>
                        <sup style="cursor:pointer" onclick="event.stopPropagation(); window.location.href=\'member-profile.php?id=' . $row['id'] . '\'">view</sup>
                    </div>
                  ';

            generateTree($row['id'], true); // Recursive call with $isSubparent as true for deeper levels
            echo '</li>';
        }
        echo '</ul>';
    }
}


// Start the tree generation

?>
<?php include "header.php" ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        /* Add your CSS here */
        .tree {
            margin: 0;
            padding: 0;
            list-style: none;
                overflow-x: scroll;
        }
        .tree ul {
            margin: 0;
            padding: 0;
            list-style: none;
            margin-left: 1em;
            position: relative;
            min-width: 430px;
        }
        
        .tree ul ul {
            margin-left: 0.5em;
        }
        .tree ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            border-left: 1px solid;
        }
        .tree ul li:before {
            content: "";
            display: block;
            width: 10px;
            height: 0;
            border-top: 1px solid;
            margin-top: -1px;
            position: absolute;
            top: 1em;
            left: 0;
        }
        .tree ul li:after {
            content: '';
            position: absolute;
            top: 12.6px;
            width: 6px;
            height: 6px;
            /* border: 2px solid #336699; */
            background-color: #336699;
            border-radius: 50%;
            left: -3px;
        }
        .tree ul li:last-child:before {
            height: auto;
            top: 1em;
            bottom: 0;
        }
        .tree li {
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            color: #369;
            font-weight: 600;
            position: relative;
            font-size: 13px;
        }
        .tree li .expand {
            display: block;
        }
        .tree li .collapse {
            display: none;
        }
        .tree li a {
            text-decoration: none;
            color: #369;
        }
        .tree li button {
            text-decoration: none;
            border: none;
            background: transparent;
            margin: 0;
            padding: 0;
            outline: 0;
        }
        .tree li button:active,
        .tree li button:focus {
            text-decoration: none;
            color: #369;
            border: none;
            background: transparent;
            margin: 0;
            padding: 0;
            outline: 0;
        }
        .indicator {
            margin-right: 5px;
        }
        
        
        
        /* General tree structure styles remain the same */
.userbtn {
    display: inline;
    padding: 1px 10px;
    border-radius: 10px;
}

/* Specific styles for parent and subparent */
.userbtn.parent {
    border: 1px solid #dd7646;
    color: #e15d0a;
}
.userbtn.Agent
{
     border: 1px solid #1e90ff;
     color:#6e6b0a;
}
.userbtn.Agent button{
     color:#1e90ff;
}
.userbtn.Distributor
{
     border: 1px solid #6e6b0a;
     color:#6e6b0a;
}
.userbtn.Distributor button{
     color:#1e90ff;
}
.userbtn.Dealer
{
     border: 1px solid #761183;
     color:#761183;
}
.userbtn.Customer
{
     border: 1px solid #831111;
     color:#831111;
}
        
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                  <ul id="tree1" class="tree">
                    <?php
                   generateTree($uid);
                    ?>
                </ul>
            </div>
        </div>
       
    </div>
   
    <script>
        // JavaScript code for interaction
    </script>
<?php include "footer.php" ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tree = document.getElementById("tree1");
        if (tree) {
            tree.querySelectorAll("li").forEach(function(li) {
                // Create and configure the indicator image
                var indicator = document.createElement("img");
                indicator.classList.add("indicator");
                indicator.src = "images/men.svg"; // Set the default image source
                li.insertBefore(indicator, li.firstChild);

                var ul = li.querySelector("ul");
                if (ul) {
                    li.classList.add("branch");
                    ul.classList.add("collapse");

                    li.addEventListener("click", function(event) {
                        if (li === event.target || li === event.target.parentNode) {
                            if (ul.classList.contains('collapse')) {
                                ul.classList.remove("collapse");
                                ul.classList.add("expand");
                                indicator.src = "images/men.svg"; // Update indicator for expanded state
                            } else {
                                ul.classList.remove("expand");
                                ul.classList.add("collapse");
                                indicator.src = "images/men.svg"; // Update indicator for collapsed state
                            }
                            event.stopPropagation(); // Prevent click event from bubbling up
                        }
                    });
                }
            });
        }
    });
</script>

