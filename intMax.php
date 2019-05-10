<?php

include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

//Checking if Post is not null
if ($_POST){

//Assigning the Control Type Posted
$series = $_POST['series'];

// echo $shade;`
// echo $railroad;
$myWidth = null;

//If it Control Type is not Null and not Neo Then go
if ( $series != 'null' ){
            // $myquery = "SELECT Description, image, Colour FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND series = '$series' AND `group` = '$group' ORDER BY Colour Asc;";
            // echo $myquery;
            $resultSet = $conn->query("SELECT `max` FROM _int_max WHERE fabric = '$series';");

            $row_cnt = $resultSet->num_rows;

            if($row_cnt == 1){
            while($rows = $resultSet->fetch_assoc())
            {
                $max = $rows['max'];
            }
                // $json = array('discount' => $width);
                echo json_encode($max);      
                // echo(json_encode(($width)));
            }
            
            if($row_cnt == 0){
                // echo "0"; 
            }
            }
        }

?>