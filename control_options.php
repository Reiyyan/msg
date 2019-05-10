<?php

require 'config.php';
require 'calculus.php';

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
    $power = $_POST['power'];

    $shade = strtolower($_POST['shade']);

/*---------------------------------------------------------------------------------------------------*/
//Control Options Printing

    //Motor Setup
    if($control_system == 'Motor'){

        if($shade != 'panel track' && $shade != 'roman shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE power = '$power' AND $fabric_width >= min_width;";
            echo $controllersQuery;
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {
                echo ("<option selected disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                    echo "<option value='$controllers'>$controllers</option>";
                }
            }
            else{
                echo ("<option selected disabled value='N/A'>―No Available Control―</option>");
            }
        }  
        else if($shade == 'panel track'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _panel_control_type WHERE power = '$power' AND $fabric_width >= min_width;";
            echo $controllersQuery;
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {
                echo ("<option selected disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                    echo "<option value='$controllers'>$controllers</option>";
                }
            }
            else{
                echo ("<option selected disabled value='N/A'>―No Available Control―</option>");
            }
        }
        else if($shade == 'roman shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _roman_control_type WHERE power = '$power' AND $fabric_width >= min_width;";
            echo $controllersQuery;
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {
                echo ("<option selected disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                    echo "<option value='$controllers'>$controllers</option>";
                }
            }
            else{
                echo ("<option selected disabled value='N/A'>―No Available Control―</option>");
            }
        }    
    }

    if($control_system == 'Chain'){

        if($shade == 'roller shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width;";
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {

            echo ("<option disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                    if($controllers == "Ultra Series"){
                        echo "<option value='$controllers' style='display:none'>$controllers</option>";
                        }
                        else
                        echo "<option value='$controllers'>$controllers</option>";
                }              
            }
        }

        else if($shade == 'interlude shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width AND shade = 'Int';";
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {

            echo ("<option disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                        echo "<option value='$controllers'>$controllers</option>";
                }
                
            }
        }
        else if($shade == 'illusion shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width AND shade = 'Ill';";
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {

            echo ("<option disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                        echo "<option value='$controllers'>$controllers</option>";
                }
                
            }
        }
        else if($shade == "gemini dual shade"){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width and motor_clutches = 'SL10';";
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {

            echo ("<option disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                    if($controllers == "Ultra Series"){
                        echo "<option value='$controllers' style='display:none'>$controllers</option>";
                        }
                        else
                        echo "<option value='$controllers'>$controllers</option>";
                }
                
            }
        }
        else{
        echo ("<option selected disabled value='N/A'>―No Available Control―</option>");
        }   
    }

    if($control_system == 'Chain - Vision'){
        $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width;";
        $cresult = $conn->query($controllersQuery);

        if ($cresult->num_rows > 0) {

        echo ("<option disabled value='N/A'>―Select Your Control―</option>");

            // output data of each row
            while($row = $cresult->fetch_assoc()) {
                $controllers = $row["control_control"];
                    echo "<option value='$controllers'>$controllers</option>";
            }
            
        }
    }

    if($control_system == 'Cord'){
        if($shade == 'roman shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _roman_control_type WHERE control_system = '$control_system' AND $fabric_width >= min_width;";
            echo $controllersQuery;
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {
                echo ("<option selected disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                    echo "<option value='$controllers'>$controllers</option>";
                }
            }
            else{
                echo ("<option selected disabled value='N/A'>―No Available Control―</option>");
            }
        }

        else if($shade == 'interlude shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = 'chain' AND $fabric_width >= min_width AND shade = 'Int';";
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {

            echo ("<option disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                        echo "<option value='$controllers'>$controllers</option>";
                }
                
            }
        }

        else if($shade == 'illusion shade'){
            $controllersQuery = "SELECT DISTINCT control_control FROM _control_type WHERE control_system = 'chain' AND $fabric_width >= min_width AND shade = 'Ill';";
            $cresult = $conn->query($controllersQuery);

            if ($cresult->num_rows > 0) {

            echo ("<option disabled value='N/A'>―Select Your Control―</option>");

                // output data of each row
                while($row = $cresult->fetch_assoc()) {
                    $controllers = $row["control_control"];
                        echo "<option value='$controllers'>$controllers</option>";
                }
                
            }
        }
        

    }
/*---------------------------------------------------------------------------------------------------*/
    

$conn->close();

}


?>