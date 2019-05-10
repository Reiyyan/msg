
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
    $chain_array = array();
    $neo_array = array();

    $control_system = $_POST['control_system'];

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
//Control Options Printing
    $system_deflection_intersection =   array_values(array_intersect($possibleDeflectionTubes, $sysAdmArray));



    //Neo Query and Array Setup (WHERE NEO 1 and 1.5 are done)
    if($control_system == 'Neo'){
        for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++){
            $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);


            $tneoQuery = "SELECT neo FROM _tubes_neo WHERE tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
            $tneoresult = $conn->query($tneoQuery);

            if ($tneoresult->num_rows > 0) {
                array_push($motor_tube_admissibility, $system_deflection_intersection[$i]);
                
                // output data of each row
                while($row = $tneoresult->fetch_assoc()) {
                    $neo_options = $row["neo"];
                    array_push($neo_array, $neo_options);
                }
            }
        }
    
    //NEO VISION
    //Select Neo 1.5 if both 1 and 1.5 are possible.
    if(sizeof($neo_array) == 1 && $shade == "vision shade"){

        $shade = 'vision';
        echo "One Neo Option - Vision <br>";
        echo $neo_array[0];
        echo '<br>';
        
        
        $neo_tube = pickNeo($neo_array[0]);
        $selectedTube = selectTube($neo_tube);
        
       //RUD Calculations
       $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);


        $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$neo_array[0]' AND clearance > $⌀ AND FIND_IN_SET('$shade', shade);";
        $coptionsresult = $conn->query($coptionsquery);

        //echo ('<option disabled selected value="N/A">―Select Your Valance―</option>');

        while($rows = $coptionsresult->fetch_assoc()) {
            $optionName = $rows['valance'];
            $optionURL = $rows['image'];
            
            echo("
            <div class='sg-box hem-box'>
                <label for='$optionName'> 
                    <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                </label>
                <label class='sg-swatch-label'>
                        <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                        <span class='check-text'>$optionName</span>                                
                        <span class='sg-check'></span>
                </label>
            </div>
        ");

        }
    }
    
    else if(sizeof($neo_array) == 2 && $shade == 'roller shade'){
        $shade = "roller";
        echo "<br>";
        echo "Two Neo Options <br>";
        echo $neo_array[1];
        echo "<br>";

        $neo_tube = pickNeo($neo_array[1]);
        $selectedTube = selectTube($neo_tube);
         
        //RUD Calculations
        $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);

        $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$neo_array[1]' AND clearance > $⌀ AND FIND_IN_SET('$shade', shade);";
        $coptionsresult = $conn->query($coptionsquery);

        //echo ('<option disabled selected value="N/A">―Select Your Valance―</option>');


         while($rows = $coptionsresult->fetch_assoc()) {
            $optionName = $rows['valance'];
            $optionURL = $rows['image'];
            
            echo("
            <div class='sg-box hem-box'>
                <label for='$optionName'> 
                    <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                </label>
                <label class='sg-swatch-label'>
                        <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                        <span class='check-text'>$optionName</span>                                
                        <span class='sg-check'></span>
                </label>
            </div>
            ");
        }
    }
    else if(sizeof($neo_array) == 1 && $shade == 'roller shade'){
        // echo "One Neo Option <br>";
        // echo $neo_array[0];
        // echo '<br>';
        $shade = "roller";        
        
        $neo_tube = pickNeo($neo_array[0]);
        $selectedTube = selectTube($neo_tube);
        
       //RUD Calculations
       $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);


        $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$neo_array[0]' AND clearance > $⌀ AND FIND_IN_SET('$shade', shade);";
        // echo $coptionsquery;
        $coptionsresult = $conn->query($coptionsquery);

        //echo ('<option disabled selected value="N/A">―Select Your Valance―</option>');

        while($rows = $coptionsresult->fetch_assoc()) {
            $optionName = $rows['valance'];
            $optionURL = $rows['image'];
            
            echo("
            <div class='sg-box hem-box'>
                <label for='$optionName'> 
                    <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                </label>
                <label class='sg-swatch-label'>
                        <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                        <span class='check-text'>$optionName</span>                                
                        <span class='sg-check'></span>
                </label>
            </div>
        ");

        }
    }
    else{
        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>";
    }

    }  
 
/*---------------------------------------------------------------------------------------------------*/

//echo ('in the neo filters');
$conn->close();

}


?>