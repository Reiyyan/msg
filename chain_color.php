<?php

include 'config.php';

$tubesIndex;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/*---------------------------------------------------------------------------------------------------*/
//Colors Printing

        $cQuery = "SELECT color FROM _chain_color;";
        $cresult = $conn->query($cQuery);

        if ($cresult->num_rows > 0) {
            echo ("<option selected disabled value='N/A'>―Select Your Color―</option>");

            // output data of each row
            while($row = $cresult->fetch_assoc()) {
                $color = $row["color"];
                echo "<option value='$color'>$color</option>";
            }
        }
        else{
            echo ("<option selected disabled value='N/A'>―No Available Color―</option>");
        }   
    
/*---------------------------------------------------------------------------------------------------*/

$conn->close();



?>