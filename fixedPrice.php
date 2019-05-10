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

/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Variables
        $width = $_POST['fabric_width'];
        $length = $_POST['fabric_length'];
        $fabric_name = $_POST['fabric_name'];
        $price_group = $_POST['price_group'];
        $fabric_price = 0;

        $trim_w = $_POST['trim_w'];
        $trim = $_POST['trim'];
        $trim_price = 0;

        $pull = $_POST['pull'];
        $pull_price = 0;

        $discount = 0;

        session_start();
        if(isset($_SESSION['discount'])){
            $discount = $_SESSION['discount'];
        }

/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Fabric Price
    if(!is_null($fabric_name)){
            
            $fQuery = "SELECT `$width` FROM `_fixed_pg_$price_group` WHERE length = $length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$width"];
                    
                }
            }
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Trims & Pulls
    if(!is_null($trim)){
            $tQuery = "SELECT `$trim_w` FROM _trim WHERE Trim = '$trim';";
            //echo $tQuery;
            //echo '<br>';
            $tResult = $conn->query($tQuery);

            if ($tResult->num_rows == 1) {
                
                // output data of each row
                while($row = $tResult->fetch_assoc()) {
                    $trim_price = $row["$trim_w"];
                    
                }
            }
    }

    if(!is_null($pull)){
        $pQuery = "SELECT price FROM _pull WHERE pull = '$pull';";
        //echo $pQuery;
        //echo '<br>';
        $pResult = $conn->query($pQuery);

        if ($pResult->num_rows == 1) {
            
            // output data of each row
            while($row = $pResult->fetch_assoc()) {
                $pull_price = $row["price"];
                
            }
        }
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
$total = $fabric_price + $trim_price + $pull_price;

$json = array('discount' => $discount, 'total' => $total);

/*//echo '<br>';
//echo 'Fabric Price: ' .$fabric_price;
//echo '<br>';
//echo 'Trim Price: ' .$trim_price;
//echo '<br>';
//echo 'Pull Price: ' .$pull_price;
//echo '<br>';
//echo 'Total Price: ' .$total;*/

echo json_encode($json);      
}
$conn->close();
?>