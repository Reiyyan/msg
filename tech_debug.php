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
        $shade = $_POST['shade'];

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

        echo '<br>';
        $system_deflection_intersection =   array_values(array_intersect($possibleDeflectionTubes, $sysAdmArray));
        // echo 'Here Rei';
        // echo '<br>';
        // echo 'Deflections';
        // echo '<br>';

        // print_r($possibleDeflectionTubes);

        // echo '<br>';
        // echo 'sys array';
        // echo '<br>';
        // print_r($sysAdmArray);

        // echo '<br>';

        // echo 'intersection';
        
        // print_r($system_deflection_intersection);
        // echo '<br>';
        
        //Neo Query and Array Setup
        if($control_system == 'Neo'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
            {
                $torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

                $tneoQuery = "SELECT neo FROM _tubes_neo WHERE tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";
                echo $tneoQuery;
                echo '<br>';

                $tneoresult = $conn->query($tneoQuery);
                //print_r($tneoresult);
                if ($tneoresult->num_rows > 0) {
                    array_push($control_type_tube_admissibility, $system_deflection_intersection[$i]);
                    
                    // output data of each row
                    while($row = $tneoresult->fetch_assoc()) {
                        $neo_options = $row["neo"];
                        array_push($neo_array, $neo_options);
                    }
                }
            }

            //IF 2 neo options, select second one, if only one neo option select it. Show valance for selected neo options
            if(sizeof($neo_array) == 2){
                
                echo "<br>";
                echo "Two Neo Options <br> Selecting: ";
                echo $neo_array[1];
                echo "<br>";

                $neo_tube = pickNeo($neo_array[1]);
                $selectedTube = selectTube($neo_tube);
                
                //RUD Calculations
                $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);

                $coptionsquery = "SELECT valance FROM _drive_valances where drive = '$neo_array[1]' AND clearance > $⌀;";
                $coptionsresult = $conn->query($coptionsquery);
            }
            else if(sizeof($neo_array) == 1){
                echo "<br>";
                echo "One Neo Option <br> Selecting: ";
                echo $neo_array[0];
                print_r($neo_array);
                $neo_tube = pickNeo($neo_array[0]);
                $selectedTube = selectTube($neo_tube);
                
                //RUD Calculations
                $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);


                $coptionsquery = "SELECT valance FROM _drive_valances where drive = '$neo_array[0]' AND clearance > $⌀;";
                $coptionsresult = $conn->query($coptionsquery);
            }

        }

        //Motor Query and Array Setup
        if($control_system == 'Motor'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
            {

            $torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

            $tubeMotorQuery = "SELECT codes_desc FROM _tubes_motors WHERE tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque;";

            $tmresult = $conn->query($tubeMotorQuery);

            if ($tmresult->num_rows > 0) {
                array_push($control_type_tube_admissibility, $system_deflection_intersection[$i]);
                //echo($system_deflection_intersection[$i]);
                
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

            $torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches where tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and controller = '$control_controller';";

            //echo($system_deflection_intersection[$i]);

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
            echo ('<br>');

            $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);
            echo "torque: ";
            echo $torque;
            echo ('<br>');


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
            //echo("Selected Drive: " .$drive);
        }

        if($control_system == 'Chain'){
            $ctubequery = "SELECT tube FROM _tubes_clutches where clutch = '$motor_clutch'";
            $controltuberesult = $conn->query($ctubequery);
            $drive = $motor_clutch;
            //echo("Selected Drive: " .$drive);
        }

        if($control_system == 'Neo'){
            $neo = end($neo_array);
            $ctubequery = "SELECT tube FROM _tubes_neo where neo = '$neo'";
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



     //TODO CHECK { OVER HERE
        //IF ITS NOT FIXED THEN SHOW TUBES for selected DRIVE
        if($control_system != "Fixed"){
            if ($controltuberesult->num_rows > 0){
            while($row = $controltuberesult->fetch_assoc()) {
                //echo ($row["tube"]);
                //echo ("<br>");
                array_push($selected_control_tube, $row["tube"]);
            }
        }
     }
    /*---------------------------------------------------------------------------------------------------*/
    //Tube Selections and debug printing
        
    
        $tube_selection = array_intersect($selected_control_tube, $system_deflection_intersection, $control_type_tube_admissibility, $sysAdmArray);

        $selectedTube = selectTube(finalizeTubes($control_system, array_values($tube_selection)));  

        if (true){
            require 'vision_spring.php';
        }

        //Print Deflections
        // echo "<br> Printing Deflections";
        // echo '<pre>'; print_r($deflectionArray); echo '</pre>';


        //Selecting only the values that overlap in the previous three arrays

        echo "<br> Selected Control Tube";
        print_r ($selected_control_tube);
        echo "<br> Possible Deflection Tube";
        print_r ($possibleDeflectionTubes);
        echo "<br> Control Types Admissibility";
        print_r ($control_type_tube_admissibility);
        echo "<br> Shade System Admissibility";
        print_r ($sysAdmArray);
        echo "<br>";


        echo "<br> Possible Tubes - (Index): ";
        print_r ($tube_selection);

        //Finalizing which tube we choose.
        echo ("<br>");
        echo("Final Selection is: ");
        
        print_r ($selectedTube);
        echo ("<br><br>");
        $system_torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, ($selectedTube->tube_radius));
        echo ("Torque is: " .$system_torque ." N m");
        echo ("<br>");
        //$json = array('reitorque' => $system_torque, 'success' => true);
        
        //echo json_encode($json);
  
    /*---------------------------------------------------------------------------------------------------*/
    //RUD Calculations
        $⌀ = calculateRUD($fabric_length, $fabric_thickness,$selectedTube->tube_radius);

        echo ("RUD: " .$⌀);
    /*---------------------------------------------------------------------------------------------------*/
        $conn->close();
    }


?>