<?php
header('Content-type: text/javascript');

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

        $shade = strtolower($_POST['shade']);

        $drive;
    /*---------------------------------------------------------------------------------------------------*/
    //Fabric Section

        //Fabric Query
        $fabricquery = "SELECT Description, Thickness, Weight FROM _fabric where description = '$fabric_name';";
        $fresult = $conn->query($fabricquery);

        
        if ($fresult->num_rows == 1) {
            // output data of each row
            while($row = $fresult->fetch_assoc()) {
                $fabric_name = $row["Description"];
                $fabric_thickness = $row["Thickness"];
                $fabric_weight = $row["Weight"];
            }
        } 
        else {
            //echo "We didn't recive 1 Fabric result";
        }
        
    /*---------------------------------------------------------------------------------------------------*/
    //Hem Section

        //If No Hem Selected, set to Plain Hem
        if($hem_name == "Select Your Hem"){
            $hem_name="Plain Hem";
        }
        
        //Hem Query
        $hemquery = "SELECT Distinct hem_weight FROM _hem_type where hem_type = '$hem_name';";
        $hresult = $conn->query($hemquery);

        if ($hresult->num_rows == 1) {
            while($row = $hresult->fetch_assoc()) {
                $hem_weight = $row["hem_weight"];
            }
        } 
        else {
            //echo "We didn't recive 1 Hem result";
        }

    /*---------------------------------------------------------------------------------------------------*/
    //Tube Section (Deflections)

        $tubes = array();

        class Tube{

            var $tube_name;
            var $tube_radius;
            var $tube_weight;
            var $tube_inertia;

            public function  __construct($tube_name, $tube_radius, $tube_weight, $tube_inertia) {
                $this->tube_name = $tube_name;
                $this->tube_radius = $tube_radius;
                $this->tube_weight = $tube_weight;
                $this->tube_inertia = $tube_inertia;
            }

        }

        $selectedTube = new Tube(0,0,0,0);

        $tubequery = "SELECT name, radius, weight, inertia FROM _tube;";
        $tresult = $conn->query($tubequery);

        //Creating Tubes Array and Tube Objects
        if ($tresult->num_rows > 0) {
            while($row = $tresult->fetch_assoc()) {
                
                $tubes[] = $row;

            }

            //Separating the tubes from the arrays, into objects
            $tube_0 = new Tube($tubes[0]["name"],$tubes[0]["radius"],$tubes[0]["weight"],$tubes[0]["inertia"]);
            $tube_1 = new Tube($tubes[1]["name"],$tubes[1]["radius"],$tubes[1]["weight"],$tubes[1]["inertia"]);
            $tube_2 = new Tube($tubes[2]["name"],$tubes[2]["radius"],$tubes[2]["weight"],$tubes[2]["inertia"]);
            $tube_3 = new Tube($tubes[3]["name"],$tubes[3]["radius"],$tubes[3]["weight"],$tubes[3]["inertia"]);
            $tube_4 = new Tube($tubes[4]["name"],$tubes[4]["radius"],$tubes[4]["weight"],$tubes[4]["inertia"]);
            $tube_5 = new Tube($tubes[5]["name"],$tubes[5]["radius"],$tubes[5]["weight"],$tubes[5]["inertia"]);
            $tube_6 = new Tube($tubes[6]["name"],$tubes[6]["radius"],$tubes[6]["weight"],$tubes[6]["inertia"]);
            $tube_7 = new Tube($tubes[7]["name"],$tubes[7]["radius"],$tubes[7]["weight"],$tubes[7]["inertia"]);

        }

        //Calculating Deflection for each Tube
        foreach($tubes as $tube){
        $deflection = deflectionCalculus($fabric_width, $fabric_length, $fabric_weight, $tube['weight'], $hem_weight, $tube['inertia']);

        array_push($deflectionArray, $deflection);
        } 


    /*---------------------------------------------------------------------------------------------------*/
    //Tube Admissibility

    
        require 'section/admissibility_section.php';


    /*---------------------------------------------------------------------------------------------------*/
    //Deflection Admissibility Array
        checkTube($tubes, $deflectionArray, $admArray);
    /*---------------------------------------------------------------------------------------------------*/
    //Control Options 
        $system_deflection_intersection =   array_values(array_intersect($possibleDeflectionTubes, $sysAdmArray));
    
        //CANT REPLACE ALL OLD WITH NEW CODE, NEED TO KEEP A LOCAL COPY SINCE ECHOS

        //Chain Query and Array Setup
        if($control_system == 'Chain'){
            for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
            {

            $torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

            $tubeChainQuery = "SELECT clutch FROM _tubes_clutches where tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and controller = '$control_controller';";

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
        

    
    /*---------------------------------------------------------------------------------------------------*/
    //Control Array Intersections

        if($control_system == 'Chain'){
            $ctubequery = "SELECT tube FROM _tubes_clutches where clutch = '$motor_clutch'";
            $controltuberesult = $conn->query($ctubequery);
            $drive = $motor_clutch;
            //echo("Selected Drive: " .$drive);
        
            if ($controltuberesult->num_rows > 0){
                while($row = $controltuberesult->fetch_assoc()) {
                //echo ($row["tube"]);
                // echo ("<br>");
                array_push($selected_control_tube, $row["tube"]);
                }
            }
        }
    /*---------------------------------------------------------------------------------------------------*/
    //LAM Possibility Checker

        $tube_selection = array_intersect($selected_control_tube, $system_deflection_intersection, $control_type_tube_admissibility, $sysAdmArray);

        $selectedTube = selectTube(finalizeTubes($control_system, array_values($tube_selection)));

        $system_torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, ($selectedTube->tube_radius));

        
        //r24 clutch
        $r24_check_array = array();
        $r24_array = array();
        $r24_possible;

        for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
        {

        $torque = 1.20 * calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

        $tubeChainQuery = "SELECT clutch FROM _tubes_clutches where tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and clutch = 'R24';";

        $tcresult = $conn->query($tubeChainQuery);

        if ($tcresult->num_rows > 0) {
            array_push($r24_check_array, $system_deflection_intersection[$i]);
            
            // output data of each row
            while($row = $tcresult->fetch_assoc()) {
                $chain_options = $row["clutch"];
                array_push($r24_array, $chain_options);
            }
        }
        }
        
        if(sizeof($r24_array) > 0){
            $r24_possible = true;
        }
        else{
            $r24_possible = false;
        }

        //Ultra Clutch
        $ultra_check_array = array();
        $ultra_array = array();
        $ultra_possible;

        for($i = 0; $i<= sizeof($system_deflection_intersection)-1; $i++)
        {

        $torque = calculateTorque($fabric_width, $fabric_length, $fabric_weight, $hem_weight, (selectTube($system_deflection_intersection[$i]))->tube_radius);

        $tubeChainQuery = "SELECT clutch FROM _tubes_clutches where tube = $system_deflection_intersection[$i] AND width <= $fabric_width and torque >= $torque and clutch = 'ultra';";

        $tcresult = $conn->query($tubeChainQuery);

        if ($tcresult->num_rows > 0) {
            array_push($ultra_check_array, $system_deflection_intersection[$i]);
            
            // output data of each row
            while($row = $tcresult->fetch_assoc()) {
                $chain_options = $row["clutch"];
                array_push($ultra_array, $chain_options);
            }
        }
        }
        
        if(sizeof($ultra_array) > 0){
            $ultra_possible = true;
        }
        else{
            $ultra_possible = false;
        }

        $torquequery = "SELECT distinct torque FROM _tubes_clutches where clutch = 'Ultra';";
        $torqueresult = $conn->query($torquequery);

        $rows = $torqueresult->fetch_assoc();

        if($torqueresult->num_rows == 1){
            $ultra_torque = $rows['torque'];
        }
        
        $json = array('system_torque' => $system_torque, 'ultra_torque' => $ultra_torque, 'Ultra' => $ultra_possible, "R24" => $r24_possible);
        
        echo json_encode($json);
        
    /*---------------------------------------------------------------------------------------------------*/

        $conn->close();
    }



?>