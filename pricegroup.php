<?php
header('Content-type: text/javascript');

include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

    $name = $_POST['fabric_name'];
    $price_group;

    $result = $conn->query("SELECT price_group FROM _fabric WHERE Description = '$name';");

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $price_group = $row["price_group"];  
            }
        }
        
        echo json_encode($price_group);            
                
    /*---------------------------------------------------------------------------------------------------*/

        $conn->close();
    }