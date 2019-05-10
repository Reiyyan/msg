<?php

include 'config.php';

$tubesIndex;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

    //Variables
    $fabric_width =  $_POST['fabric_width'];
    $control_system = $_POST['control_system'];
    $shade = strtolower($_POST['shade']);

/*---------------------------------------------------------------------------------------------------*/
//Control Options Printing
    
    //Motor Power Setup
    if($shade != 'panel track' && $shade != 'roman shade'){

        $powerQuery = "SELECT DISTINCT `power` FROM _control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width;";
        //echo $powerQuery;
        $presult = $conn->query($powerQuery);

        if ($presult->num_rows > 0) {
            echo ("<option selected disabled value='N/A'>―Select Your Power―</option>");

            // output data of each row
            while($row = $presult->fetch_assoc()) {
                $power = $row["power"];
                echo "<option value='$power'>$power</option>";
            }
        }
        else{
            echo ("<option selected disabled value='N/A'>―No Available Power―</option>");
        }   
    }
    else if($shade == 'panel track'){

        $powerQuery = "SELECT DISTINCT `power` FROM _panel_control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width;";
        //echo $powerQuery;
        $presult = $conn->query($powerQuery);

        if ($presult->num_rows > 0) {
            echo ("<option selected disabled value='N/A'>―Select Your Power―</option>");

            // output data of each row
            while($row = $presult->fetch_assoc()) {
                $power = $row["power"];
                echo "<option value='$power'>$power</option>";
            }
        }
        else{
            echo ("<option selected disabled value='N/A'>―No Available Power―</option>");
        }   
    }
    else if($shade == 'roman shade'){

        $powerQuery = "SELECT DISTINCT `power` FROM _roman_control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width;";
        //echo $powerQuery;
        $presult = $conn->query($powerQuery);

        if ($presult->num_rows > 0) {
            echo ("<option selected disabled value='N/A'>―Select Your Power―</option>");

            // output data of each row
            while($row = $presult->fetch_assoc()) {
                $power = $row["power"];
                echo "<option value='$power'>$power</option>";
            }
        }
        else{
            echo ("<option selected disabled value='N/A'>―No Available Power―</option>");
        }   
    }
/*---------------------------------------------------------------------------------------------------*/

$conn->close();

}

?>