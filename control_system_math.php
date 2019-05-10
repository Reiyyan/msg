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
    $fabric_name = $_POST['fabric_name'];
    $hem_name = $_POST['hem_name'];
    $δ = $_POST['δ'];
    $deflectionArray = array(); //See Tubes for Key Pairing
    $fabric_width =  $_POST['fabric_width'];
    $fabric_length =  $_POST['fabric_length'];
    $valance = $_POST['valance_type'];
    $forceConversion = 0.112985;
    $⌀;
    $motor_array = array();
    $shade = strtolower($_POST['shade']);


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
//Drive Types

    //Pick all control types
    if($shade != 'panel track' && $shade != 'roman shade'){
        if( (in_array (0, $possibleDeflectionTubes) || in_array (2, $possibleDeflectionTubes)) && $shade == 'roller shade'){
                $cTypequery = "SELECT distinct control_system FROM _control_type WHERE $fabric_width >= min_width AND control_system != 'Chain - Vision';";
                $cTyperesult = $conn->query($cTypequery);

                echo ("<option selected disabled value='N/A'>―Select Your System―</option>");
                while($rows = $cTyperesult->fetch_assoc())
                {
                $optionName = $rows['control_system'];
                echo "<option value='$optionName'>$optionName</option>"; 
                }
        }

        else if( (in_array (2, $possibleDeflectionTubes)) && $shade == 'vision shade'){
            $cTypequery = "SELECT distinct control_system FROM _control_type WHERE control_system != 'Chain' AND $fabric_width >= min_width;";
            $cTyperesult = $conn->query($cTypequery);
            echo $cTypequery;

            echo ("<option selected disabled value='N/A'>―Select Your System―</option>");
            while($rows = $cTyperesult->fetch_assoc())
            {
            $optionName = $rows['control_system'];
            echo "<option value='$optionName'>$optionName</option>"; 
            }
        }

        else if($shade == 'vision shade'){
            $cTypequery = "SELECT distinct control_system FROM _control_type WHERE control_system != 'Neo' AND control_system != 'Chain' AND $fabric_width >= min_width;";
            echo $cTypequery;

            $cTyperesult = $conn->query($cTypequery);
            echo ("<option selected disabled value='N/A'>―Select Your System―</option>");
            while($rows = $cTyperesult->fetch_assoc())
            {
            $optionName = $rows['control_system'];
            echo "<option value='$optionName'>$optionName</option>";
            }
        }

        //Pick everything except for Neo
        else{
            $cTypequery = "SELECT distinct control_system FROM _control_type WHERE control_system != 'Neo' AND control_system != 'Chain - Vision' AND $fabric_width >= min_width;";
            $cTyperesult = $conn->query($cTypequery);
            echo ("<option selected disabled value='N/A'>―Select Your System―</option>");
            while($rows = $cTyperesult->fetch_assoc())
            {
            $optionName = $rows['control_system'];
            echo "<option value='$optionName'>$optionName</option>";
            }
        }
    }
    else if ($shade == "roman shade"){

        $system_weight = 1.10 * (($fabric_width * ($fabric_length + (ceil($fabric_length/8))) * $fabric_weight ) + ($hem_weight * $fabric_width) + (($fabric_width) * ceil($fabric_length/8) * 0.003645833333125));

        echo $system_weight;

        echo $shade;
        echo '<br>';

        $cTypequery = "SELECT distinct control_system FROM _roman_control_type WHERE $fabric_width >= min_width AND $system_weight <= weight;";
        $cTyperesult = $conn->query($cTypequery);
        echo $cTypequery;

        echo ("<option selected disabled value='N/A'>―Select Your System―</option>");
        while($rows = $cTyperesult->fetch_assoc())
        {
        $optionName = $rows['control_system'];
        echo "<option value='$optionName'>$optionName</option>"; 
        }
    }
    else if ($shade == "panel track"){
        $cTypequery = "SELECT distinct control_system FROM _panel_control_type WHERE $fabric_width >= min_width;";
        $cTyperesult = $conn->query($cTypequery);
        echo $cTypequery;

        echo ("<option selected disabled value='N/A'>―Select Your System―</option>");
        while($rows = $cTyperesult->fetch_assoc()){
        $optionName = $rows['control_system'];
        echo "<option value='$optionName'>$optionName</option>"; 
        }
        // echo "<option value='Wand'>Wand</option>"; 
    }
    else{
        echo "<option disbaled value='N/A'>No Compatible System</option>"; 
    }


/*---------------------------------------------------------------------------------------------------*/


$conn->close();

}




?>