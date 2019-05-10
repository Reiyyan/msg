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

/*---------------------------------------------------------------------------------------------------------------------------------------*/
        //Variables
        $shade = $_POST['shade'];
        $fabric_name = $_POST['fabric_name'];
        $hem_name = $_POST['hem_name'];
        $δ = $_POST['δ'];
        $deflectionArray = array(); //See Tubes for Key Pairing
        $fabric_width =  $_POST['fabric_width'];
        $fabric_length =  $_POST['fabric_length'];
        $valance = $_POST['valance_type'];
        $forceConversion = 0.112985;
        $⌀;
        //Array of all possible motors
        $motor_array = array();

        //Array of Tubes that can handle deflection
        $possibleDeflectionTubes = array();

        //Array of tubes that can handle the selected control type. (filtered by deflection first)
        $control_type_tube_admissibility = array();

        //Array of tubes that can handle the selected control option.
        $selected_control_tube = array();


        //Array of all possible contols
        $motor_array = array();
        $chain_array = array();
        $neo_array = array();

        //Clutch Variables
        //$clutch_series = "R";
        $clutch_selected;

        $control_system = $_POST['control_system'];
        $control_controller = $_POST['control_controller'];
        $motor_clutch = $_POST['motor_clutch'];
        $drive;
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
    //Control Options 
        $system_deflection_intersection =   array_values(array_intersect($possibleDeflectionTubes, $sysAdmArray));
    

        //Neo Query and Array Setup
        if($control_system == 'Neo'){
         for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
         {

            $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);


            $tneoQuery = "SELECT neo FROM _tubes_neo WHERE tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
            $tneoresult = $conn->query($tneoQuery);

            if ($tneoresult->num_rows > 0) {
                array_push($control_type_tube_admissibility, $system_deflection_intersection[$i]);
                
                // output data of each row
                while($row = $tneoresult->fetch_assoc()) {
                    $neo_options = $row["neo"];
                    array_push($neo_array, $neo_options);
                }
            }
         }
            
        }

        //Motor Query and Array Setup
        if($control_system == 'Motor'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
            {

            $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

            $tubeMotorQuery = "SELECT codes_desc FROM _tubes_motors WHERE tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";

            $tmresult = $conn->query($tubeMotorQuery);

            if ($tmresult->num_rows > 0) {
                array_push($control_type_tube_admissibility, $system_deflection_intersection[$i]);
                
                // output data of each row
                while($row = $tmresult->fetch_assoc()) {
                    $motor_options = $row["codes_desc"];
                    array_push($motor_array, $motor_options);
                }
            }
            }
        }   

        //Chain Query and Array Setup
        if($control_system == 'Chain'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
            {

            $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches where tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and controller = '$control_controller';";

            //print_r($tubeChainQuery);
            //echo "<br>";

            $tcresult = $conn->query($tubeChainQuery);

            if ($tcresult->num_rows > 0) {
                array_push($control_type_tube_admissibility, $system_deflection_intersection[$i]);
                
                // output data of each row
                while($row = $tcresult->fetch_assoc()) {
                    $chain_options = $row["clutch"];
                    array_push($chain_array, $chain_options);
                }
            }
            }

            $controlquery = "SELECT control_control FROM _control_type WHERE control_system =  '$control_system';";
            $controlresult = $conn->query($controlquery);

            while($rows = $controlresult->fetch_assoc())
                        {
                            $control_control = $rows['control_control'];
                        }


        }
        
        if($control_system == 'Chain - Vision'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
            {

            $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches where tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and controller = '$control_controller';";

            //print_r($tubeChainQuery);
            //echo "<br>";

            $tcresult = $conn->query($tubeChainQuery);

            if ($tcresult->num_rows > 0) {
                array_push($control_type_tube_admissibility, $system_deflection_intersection[$i]);
                
                // output data of each row
                while($row = $tcresult->fetch_assoc()) {
                    $chain_options = $row["clutch"];
                    array_push($chain_array, $chain_options);
                }
            }
            }

            $controlquery = "SELECT control_control FROM _control_type WHERE control_system =  '$control_system';";
            $controlresult = $conn->query($controlquery);

            while($rows = $controlresult->fetch_assoc())
                        {
                            $control_control = $rows['control_control'];
                        }
        }

        if($control_system == "Fixed"){

            $controlquery = "SELECT control_control FROM _control_type WHERE control_system =  '$control_system';";
            $controlresult = $conn->query($controlquery);


            while($rows = $controlresult->fetch_assoc())
                    {
                        $control_controller = $rows['control_control'];

                    }

        }

    
    /*---------------------------------------------------------------------------------------------------*/
    //Control Array Intersections
        echo ("<br>");
        //Finding tubes that work with selected motor
        if($control_system == 'Motor'){
            $mtubequery = "SELECT tube FROM _tubes_motors where codes_desc = '$motor_clutch';";
            $controltuberesult = $conn->query($mtubequery);
            $drive = $motor_clutch;
           // echo("Selected Drive: " .$drive);
        }


        if($control_system == 'Chain'){
            $ctubequery = "SELECT tube FROM _tubes_clutches where clutch = '$motor_clutch'";
            $controltuberesult = $conn->query($ctubequery);
            $drive = $motor_clutch;
           // echo("Selected Drive: " .$drive);
        }

        if($control_system == 'Chain - Vision'){
            $ctubequery = "SELECT tube FROM _tubes_clutches where clutch = '$motor_clutch'";
            $controltuberesult = $conn->query($ctubequery);
            $drive = $motor_clutch;
            //echo("Selected Drive: " .$drive);
        }

        if($control_system == 'Cord'){
            $ctubequery = "SELECT tube FROM _tubes_clutches where clutch = '$motor_clutch'";
            $controltuberesult = $conn->query($ctubequery);
            $drive = $motor_clutch;
           // echo("Selected Drive: " .$drive);
        }


     //TODO CHECK { OVER HERE
        //IF ITS NOT FIXED THEN SHOW TUBES for selected DRIVE
        if($control_system == "Motor" || $control_system == "Chain" || $control_system == "Chain - Vision"){
            if ($controltuberesult->num_rows > 0){
            while($row = $controltuberesult->fetch_assoc()) {
                //echo ($row["tube"]);
                // echo ("<br>");
                array_push($selected_control_tube, $row["tube"]);
            }
        }
     }
    /*---------------------------------------------------------------------------------------------------*/
    //Tube Selections and debug printing
        
        //Selecting only the values that overlap in the previous three arrays
        if($shade != 'panel track'){
            $tube_selection = array_intersect($selected_control_tube, $possibleDeflectionTubes, $control_type_tube_admissibility, $sysAdmArray);
            $selectedTube = selectTube(finalizeTubes($control_system, array_values($tube_selection)));  
        }
        //echo($selectedTube->tube_name);
        
        /*
        echo "<br> Selected Control Tube";
        print_r ($selected_control_tube);
        echo "<br> Possible Deflection Tube";
        print_r ($possibleDeflectionTubes);
        echo "<br> Control Types Admissibility";
        print_r ($control_type_tube_admissibility);
        echo "<br>";

        
        echo "<br> Possible Tubes - (Index): ";
        print_r ($tube_selection);

        //Finalizing which tube we choose.
        echo ("<br>");
        echo("Final Selection is: ");


        
        print_r ($selectedTube);
        echo ("<br><br>");
        $system_torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, ($selectedTube->tube_radius));
        echo ("Torque is: " .$system_torque);
        echo ("<br>");
        
        //$json = array('reitorque' => $system_torque, 'success' => true);
        
        //echo json_encode($json);*/
  
    /*---------------------------------------------------------------------------------------------------*/
    //RUD Calculations
        $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);

    /*---------------------------------------------------------------------------------------------------*/
    //Valance Options       
            
        if($shade != 'panel track'){
            if($control_system == "Motor"){
                if($shade == 'roller shade'){
                    $shade = "roller";
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";
                    $coptionsresult = $conn->query($coptionsquery);

                    // echo $coptionsquery;
                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';
                    
                        while($rows = $coptionsresult->fetch_assoc()) {
                            $optionName = $rows['valance'];
                            $optionURL = $rows['image'];

                            //HARDCODE CBX REMOVER FOR 2" TUBE
                            if(($selectedTube->tube_name == '2') && ($optionName == 'CBX'))
                            {
                                //Skip
                            }
                            else{
                                echo("
                                <div class='sg-box hem-box'>
                                <div>
                                    <label for='$optionName'> 
                                        <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                            <span class='check-text'>$optionName</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                    </div>
                                </div>
                                "); 
                            }
                        }

                        //If No Results
                        if($row_cnt == 0){
                            echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                        }
                }

                else if($shade == 'interlude shade'){
                    $shade = 'Int';

                    //TODO VISION FROM HERE
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade)";
                    $coptionsresult = $conn->query($coptionsquery);

                    //echo $coptionsquery;
                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';
                    
                        while($rows = $coptionsresult->fetch_assoc()) {
                            $optionName = $rows['valance'];
                            $optionURL = $rows['image'];

                            echo("
                            <div class='sg-box hem-box'>
                            <div>
                                <label for='$optionName'> 
                                    <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                        <span class='check-text'>$optionName</span>                                
                                        <span class='sg-check'></span>
                                </label>
                                </div>
                            </div>
                            ");                            
                        }

                        //If No Results
                        if($row_cnt == 0){
                            echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                        }
                }

                else if($shade == 'illusion shade'){
                    $shade = 'Ill';
                    
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade)";
                    $coptionsresult = $conn->query($coptionsquery);

                    //echo $coptionsquery;
                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';
                    
                        while($rows = $coptionsresult->fetch_assoc()) {
                            $optionName = $rows['valance'];
                            $optionURL = $rows['image'];

                            echo("
                            <div class='sg-box hem-box'>
                            <div>
                                <label for='$optionName'> 
                                    <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                        <span class='check-text'>$optionName</span>                                
                                        <span class='sg-check'></span>
                                </label>
                                </div>
                            </div>
                            ");     
                        }

                        //If No Results
                        if($row_cnt == 0){
                            echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                        }
                }
                else if($shade == 'vision shade'){
                    $shade = 'vision';
                    
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade) ORDER BY valance";
                    $coptionsresult = $conn->query($coptionsquery);

                    //echo $coptionsquery;
                    $row_cnt = $coptionsresult->num_rows;
                    
                        while($rows = $coptionsresult->fetch_assoc()) {
                            $optionName = $rows['valance'];
                            $optionURL = $rows['image'];

                            echo("
                            <div class='sg-box hem-box'>
                                <div>
                                <label for='$optionName'> 
                                    <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                        <span class='check-text'>$optionName</span>                                
                                        <span class='sg-check'></span>
                                </label>
                                </div>
                            </div>
                            "); 

                        }

                        //If No Results
                        if($row_cnt == 0){
                            echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>";
                        }
                }
                else if($shade == 'gemini dual shade'){
                    $shade = "gemini";
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";
                    // echo $coptionsquery;
                    $coptionsresult = $conn->query($coptionsquery);

                    //echo $coptionsquery;
                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';
                    
                        while($rows = $coptionsresult->fetch_assoc()) {
                            $optionName = $rows['valance'];
                            $optionURL = $rows['image'];

                            //HARDCODE CBX REMOVER FOR 2" TUBE
                            if(($selectedTube->tube_name == '2') && ($optionName == 'CBX'))
                            {
                                //Skip
                            }
                            else{
                                echo("
                                <div class='sg-box hem-box'>
                                <div>
                                    <label for='$optionName'> 
                                        <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                            <span class='check-text'>$optionName</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                    </div>
                                </div>
                                "); 
                            }
                        }

                        //If No Results
                        if($row_cnt == 0){
                            echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                        }
                }
            }

            else if($control_system == "Chain"){

                $clutches_possible = (array_values(array_unique($chain_array)));

                if($shade == 'roller shade'){
                    
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width;";

                    $coptionsresult = $conn->query($coptionsquery);

                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';

                    while($rows = $coptionsresult->fetch_assoc()) {
                        $optionName = $rows['valance'];
                        $optionURL = $rows['image'];
                        //HARDCODE CBX REMOVER FOR 2" TUBE
                        if(($selectedTube->tube_name == '2') && ($optionName == 'CBX'))
                        {
                            //Skip
                        }
                        else{
                            
                            echo("
                                <div class='sg-box hem-box'>
                                <div>
                                    <label for='$optionName'> 
                                        <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                            <span class='check-text'>$optionName</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                    </div>
                                </div>
                            ");
                            
                            //echo "<option value='$optionName'>$optionName</option>"; 
                        }
                    }

                    

                    //If No Results
                    if($row_cnt == 0){
                        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                    }
                }

                else if($shade == 'interlude shade'){
                    $shade = 'Int';

                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";

                    echo $coptionsquery;

                    $coptionsresult = $conn->query($coptionsquery);

                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';

                    while($rows = $coptionsresult->fetch_assoc()) {
                        $optionName = $rows['valance'];
                        $optionURL = $rows['image'];

                        echo("
                        <div class='sg-box hem-box'>
                        <div>
                            <label for='$optionName'> 
                                <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                            </label>
                            <label class='sg-swatch-label'>
                                    <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                    <span class='check-text'>$optionName</span>                                
                                    <span class='sg-check'></span>
                            </label>
                            </div>
                        </div>
                        ");     
                    }

                    //If No Results
                    if($row_cnt == 0){
                        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                    }
                }

                else if($shade == 'illusion shade'){
                    $shade = 'Ill';

                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";
                    $coptionsresult = $conn->query($coptionsquery);

                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';

                    while($rows = $coptionsresult->fetch_assoc()) {
                        $optionName = $rows['valance'];
                        $optionURL = $rows['image'];

                        echo("
                        <div class='sg-box hem-box'>
                        <div>
                            <label for='$optionName'> 
                                <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                            </label>
                            <label class='sg-swatch-label'>
                                    <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                    <span class='check-text'>$optionName</span>                                
                                    <span class='sg-check'></span>
                            </label>
                            </div>
                        </div>
                        ");     
                    }

                    //If No Results
                    if($row_cnt == 0){
                        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>";
                    }
                }
                else if($shade == 'gemini dual shade'){
                    $shade = "gemini";
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";
                    
                    $coptionsresult = $conn->query($coptionsquery);

                    //echo $coptionsquery;
                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';
                    
                        while($rows = $coptionsresult->fetch_assoc()) {
                            $optionName = $rows['valance'];
                            $optionURL = $rows['image'];

                            //HARDCODE CBX REMOVER FOR 2" TUBE
                            if(($selectedTube->tube_name == '2') && ($optionName == 'CBX'))
                            {
                                //Skip
                            }
                            else{
                                echo("
                                <div class='sg-box hem-box'>
                                <div>
                                    <label for='$optionName'> 
                                        <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                            <span class='check-text'>$optionName</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                    </div>
                                </div>
                                "); 
                            }
                        }

                        //If No Results
                        if($row_cnt == 0){
                            echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                        }
                }

            }

            else if($control_system == "Cord"){
                if($shade == 'illusion shade'){
                    $shade = 'Ill';

                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";
                    $coptionsresult = $conn->query($coptionsquery);

                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';

                    while($rows = $coptionsresult->fetch_assoc()) {
                        $optionName = $rows['valance'];
                        $optionURL = $rows['image'];

                        echo("
                        <div class='sg-box hem-box'>
                        <div>
                            <label for='$optionName'> 
                                <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                            </label>
                            <label class='sg-swatch-label'>
                                    <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                    <span class='check-text'>$optionName</span>                                
                                    <span class='sg-check'></span>
                            </label>
                            </div>
                        </div>
                        ");     
                    }

                    //If No Results
                    if($row_cnt == 0){
                        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>";
                    }
                }

                else if($shade == 'interlude shade'){
                    $shade = 'Int';

                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width AND FIND_IN_SET('$shade', shade);";
                    $coptionsresult = $conn->query($coptionsquery);
                    echo $coptionsquery;

                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';

                    while($rows = $coptionsresult->fetch_assoc()) {
                        $optionName = $rows['valance'];
                        $optionURL = $rows['image'];

                        echo("
                        <div class='sg-box hem-box'>
                        <div>
                            <label for='$optionName'> 
                                <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                            </label>
                            <label class='sg-swatch-label'>
                                    <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                    <span class='check-text'>$optionName</span>                                
                                    <span class='sg-check'></span>
                            </label>
                            </div>
                        </div>
                        ");     
                    }

                    //If No Results
                    if($row_cnt == 0){
                        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>";
                    }
                }
            }

            else if($control_system == "Chain - Vision"){

                $clutches_possible = (array_values(array_unique($chain_array)));

                if($shade == 'vision shade'){
                    
                    $coptionsquery = "SELECT valance, image FROM _drive_valances where drive = '$drive' AND clearance > $⌀ AND $fabric_width <= width ORDER BY valance;";
                    $coptionsresult = $conn->query($coptionsquery);

                    $row_cnt = $coptionsresult->num_rows;

                    //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';

                    while($rows = $coptionsresult->fetch_assoc()) {
                        $optionName = $rows['valance'];
                        $optionURL = $rows['image'];

                            echo("
                                <div class='sg-box hem-box'>
                                    <div>
                                    <label for='$optionName'> 
                                        <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                            <span class='check-text'>$optionName</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                    </div>
                                </div>
                            ");
                            
                            //echo "<option value='$optionName'>$optionName</option>"; 
                        
                    }

                    //If No Results
                    if($row_cnt == 0){
                        echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                    }
                }
            }
        }
        else if($shade == 'panel track'){
            $shade = "panel";
            $coptionsquery = "SELECT valance, image FROM _drive_valances WHERE FIND_IN_SET('$shade', shade);";
            // echo $coptionsquery;
            $coptionsresult = $conn->query($coptionsquery);

            //echo $coptionsquery;
            $row_cnt = $coptionsresult->num_rows;

            //echo '<option disabled selected value="N/A">―Select Your Valance―</option>';
            
                while($rows = $coptionsresult->fetch_assoc()) {
                    $optionName = $rows['valance'];
                    $optionURL = $rows['image'];


                        echo("
                        <div class='sg-box hem-box'>
                        <div>
                            <label for='$optionName'> 
                                <img class='sg-box-image' src='$optionURL' alt='$optionName'>
                            </label>
                            <label class='sg-swatch-label'>
                                    <input type='radio' class='valanceRadio' name='valance' onclick='getValance(this.value)' id='$optionName' value='$optionName'>
                                    <span class='check-text'>$optionName</span>                                
                                    <span class='sg-check'></span>
                            </label>
                            </div>
                        </div>
                        "); 
                    }

                //If No Results
                if($row_cnt == 0){
                    echo "No Valances Available,<p class='size-error'>Current Selection Exceeds Limitations</p>"; 
                }
        }
                
    /*---------------------------------------------------------------------------------------------------*/

        $conn->close();
    }


?>