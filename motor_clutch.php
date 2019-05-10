
<?php
//Max height with Given Width

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
    $fabric_name = $_POST['fabric_name'];
    $hem_name = $_POST['hem_name'];
    $δ = $_POST['δ'];
    $deflectionArray = array(); //See Tubes for Key Pairing
    $fabric_width =  $_POST['fabric_width'];
    $fabric_length =  $_POST['fabric_length'];
    $valance = $_POST['valance_type'];
    $forceConversion = 0.112985;
    $⌀;

    //Array of Tubes that can handle deflection
    $possibleDeflectionTubes = array();

    //Array of tubes that can handle the motor (filtered by deflection first)
    $motor_tube_admissibility = array();

    //Array of all possible contols
    $motor_array = array();
    $clutch_array = array();
    $neo_array = array();

    //Clutch Variables
    $clutch_series = "R";

    $control_system = $_POST['control_system'];
    $control_power = $_POST['control_power'];
    $control_controller = $_POST['control_controller'];

    $shade = strtolower($_POST['shade']);
    // echo $shade;

    //echo ($control_system);

/*---------------------------------------------------------------------------------------------------*/
//Fabric Section

    require 'section/fabric_section.php';
    
/*---------------------------------------------------------------------------------------------------*/
//Hem Section

    require 'section/hem_section.php';

/*---------------------------------------------------------------------------------------------------*/
//Tube Section (Deflections)

    require 'section/tube_deflection_section.php';

/*---------------------------------------------------------------------------------------------------*/
//Tube Admissibility

    require 'section/admissibility_section.php';

/*---------------------------------------------------------------------------------------------------*/
//Deflection Admissibility Array 
    checkTube($tubes, $deflectionArray, $admArray);
/*---------------------------------------------------------------------------------------------------*/
//Control Options Printing

    $system_deflection_intersection =   array_values(array_intersect($possibleDeflectionTubes, $sysAdmArray));
    
    //Motor Query and Array Setup
    if($control_system == 'Motor'){
        if($shade != 'panel track' && $shade != 'roman shade'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++){

                $torque = 1.20 * (calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius));

                $tubeMotorQuery = "SELECT codes_desc FROM _tubes_motors WHERE `power` = '$control_power' AND controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
                
                //echo $tubeMotorQuery;
                
                $tmresult = $conn->query($tubeMotorQuery);

                if ($tmresult->num_rows > 0) {
                    array_push($motor_tube_admissibility, $system_deflection_intersection[$i]);
                    
                    // output data of each row
                    while($row = $tmresult->fetch_assoc()) {
                        $motor_options = $row["codes_desc"];
                        array_push($motor_array, $motor_options);
                    }
                }
            }
        
            if (sizeof($motor_array) > 0){
                //echo "Motor: ";
                //echo "<select id='motor_clutch' onchange='valanceFilter(); unlockValanceType(); getPrice();'>";
                echo ("<option selected disabled value='N/A'>―Select Your Control Option―</option>");
                    foreach(array_unique($motor_array) as $motors)
                    {
                        echo "<option value='$motors'>$motors</option>"; 
                    }
                //echo "</select>";
                }

                else{
                //echo "<select id='motor_clutch'>";
                echo ("<option selected disabled value='N/A'>―No Available Motors―</option>");
                //echo "</select>";}
            }
        }
        //GOTTA DO WEIGHT MATH HERE
        else if($shade == 'panel track'){
            $system_weight = 1.10 * ($fabric_width *  $hem_weight + $fabric_width * $fabric_length * $fabric_weight);
            // echo $system_weight;

            $tubeMotorQuery = "SELECT motor_clutches FROM _panel_control_type WHERE `power` = '$control_power' AND control_control = '$control_controller' and min_width <= '$fabric_width' and $system_weight <= weight";
            // echo $tubeMotorQuery;

            $tmresult = $conn->query($tubeMotorQuery);

            if ($tmresult->num_rows > 0) { 
                echo ("<option selected disabled value='N/A'>―Select Your Control Option―</option>");
                // output data of each row
                while($row = $tmresult->fetch_assoc()) {
                    $motor_options = $row["motor_clutches"];
                    echo "<option value='$motor_options'>$motor_options</option>";     
                }
            }

        }
        else if($shade == 'roman shade'){
            $system_weight = 1.10 * (($fabric_width * ($fabric_length + (ceil($fabric_length/8))) * $fabric_weight ) + ($hem_weight * $fabric_width) + (($fabric_width) * ceil($fabric_length/8) * 0.003645833333125));

            //echo $system_weight;

            $tubeMotorQuery = "SELECT motor_clutches FROM _roman_control_type WHERE `power` = '$control_power' AND control_control = '$control_controller' and min_width <= '$fabric_width' and $system_weight <= weight";
            //echo $tubeMotorQuery;

            $tmresult = $conn->query($tubeMotorQuery);

            if ($tmresult->num_rows > 0) { 
                echo ("<option selected disabled value='N/A'>―Select Your Control Option―</option>");
                // output data of each row
                while($row = $tmresult->fetch_assoc()) {
                    $motor_options = $row["motor_clutches"];
                    echo "<option value='$motor_options'>$motor_options</option>";     
                }
            }

        }
    }   

    //Chain Query and Array Setup
    else if($control_system == 'Chain'){
        for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
        {

        $torque = 1.20 * (calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius));

        if($shade == "gemini dual shade"){
            //echo "in gemini";
            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches WHERE controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and gemini = true;";

            //echo $tubeChainQuery;
        }
        else{
            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches WHERE controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and clutch != 'SL15';";
        }

        // $tubeChainQuery = "SELECT clutch FROM _tubes_clutches WHERE controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
        //echo($tubeChainQuery);
         //   echo("<br>");
        $tcresult = $conn->query($tubeChainQuery);

        if ($tcresult->num_rows > 0) {
            array_push($motor_tube_admissibility, $system_deflection_intersection[$i]);
            
            // output data of each row
            while($row = $tcresult->fetch_assoc()) {
                $clutch_options = $row["clutch"];
                array_push($clutch_array, $clutch_options);
            }
        }
        }

        if (sizeof($clutch_array) > 0){
            
            
                //echo ("<option disabled value='N/A'>―Select Your Clutch―</option>");
                foreach(array_unique($clutch_array) as $clutch)
                {
                    if($clutch == "Ultra"){
                    echo "<option value='$clutch' disabled style='display:none';>$clutch</option>"; 
                    }
                    else
                    echo "<option value='$clutch'>$clutch</option>"; 
                }
             
            }
    
            else{
            echo "<select id='motor_clutch'>";
            echo ("<option selected disabled value='N/A'>―No Available Clutch―</option>");
            
        }
    }

    else if($control_system == 'Chain - Vision'){
        for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
        {

        $torque = 1.20 * (calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius));

        $tubeChainQuery = "SELECT clutch FROM _tubes_clutches WHERE controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
        //echo($tubeChainQuery);
         //   echo("<br>");
        $tcresult = $conn->query($tubeChainQuery);

        if ($tcresult->num_rows > 0) {
            array_push($motor_tube_admissibility, $system_deflection_intersection[$i]);
            
            // output data of each row
            while($row = $tcresult->fetch_assoc()) {
                $clutch_options = $row["clutch"];
                array_push($clutch_array, $clutch_options);
            }
        }
        }

        if (sizeof($clutch_array) > 0){            
            //echo ("<option disabled value='N/A'>―Select Your Clutch―</option>");
            foreach(array_unique($clutch_array) as $clutch)
            {
                echo "<option value='$clutch'>$clutch</option>"; 
            }           
        }
    
        else{
            echo "<select id='motor_clutch'>";
            echo ("<option selected disabled value='N/A'>―No Available Clutch―</option>");
        }
    }
    else if($control_system == 'Cord' && $shade == 'roman shade'){
        $system_weight = 1.10 * (($fabric_width * ($fabric_length + (ceil($fabric_length/8))) * $fabric_weight ) + ($hem_weight * $fabric_width) + (($fabric_width) * ceil($fabric_length/8) * 0.003645833333125));

        // echo $system_weight;

        $cordQuery = "SELECT motor_clutches FROM _roman_control_type WHERE control_control = '$control_controller' AND min_width <= '$fabric_width' AND $system_weight <= weight";
        // echo $cordQuery;

        $cresult = $conn->query($cordQuery);

        if ($cresult->num_rows > 0) { 
            echo ("<option selected disabled value='N/A'>―Select Your Control Option―</option>");
            // output data of each row
            while($row = $cresult->fetch_assoc()) {
                $motor_options = $row["motor_clutches"];
                echo "<option value='$motor_options'>$motor_options</option>";     
            }
        }

    }
    else if($control_system == 'Cord'){
        for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
        {
        $torque = 1.20 * (calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius));

        if($shade == "interlude shade" || $shade == 'illusion shade'){
            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches WHERE controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and clutch != 'SL15';";
        }

        // $tubeChainQuery = "SELECT clutch FROM _tubes_clutches WHERE controller = '$control_controller' AND tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
        // echo($tubeChainQuery);
         //   echo("<br>");
        $tcresult = $conn->query($tubeChainQuery);

        if ($tcresult->num_rows > 0) {
            array_push($motor_tube_admissibility, $system_deflection_intersection[$i]);
            
            // output data of each row
            while($row = $tcresult->fetch_assoc()) {
                $clutch_options = $row["clutch"];
                array_push($clutch_array, $clutch_options);
            }
        }
        }

        if (sizeof($clutch_array) > 0){
            
                //echo ("<option disabled value='N/A'>―Select Your Clutch―</option>");
                foreach(array_unique($clutch_array) as $clutch)
                {
                    if($clutch == "Ultra"){
                    echo "<option value='$clutch' disabled style='display:none';>$clutch</option>"; 
                    }
                    else
                    echo "<option value='$clutch'>$clutch</option>"; 
                }
             
            }
    
            else{
            echo "<select id='motor_clutch'>";
            echo ("<option selected disabled value='N/A'>―No Available Clutch―</option>");
            
        }
    }
 
/*---------------------------------------------------------------------------------------------------*/

$conn->close();

}


?>



