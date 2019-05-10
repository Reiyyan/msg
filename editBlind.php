<?php
header('Content-type: text/javascript');

require 'include/o_db.php';

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 

if ($_POST){
    // $fabric_name = $_POST['fabric_name'];

    $eREID = $_POST['reid'];

    $query = "SELECT * FROM order_entry where `reid` = '$eREID';";
    $result = $conn->query($query);
    
    $row_cnt = $result->num_rows;

    $json = array('Test' => "Working", 'total' => "No total");

    if($row_cnt > 0){
    // echo ('<option disabled value="N/A">―Select Your Colour―</option>');
        while($rows = $result->fetch_assoc()) {
            // array_push($json, "mykey" => "apple", "otherkey" =>  "raspberry");
            $json["reid"] = $rows['reid'];
            $json["orderTag"] = $rows['orderTag'];
            $json["shadeID"] = $rows['shadeID'];
            $json["quantity"] = $rows['quantity'];
            $json["width"] = $rows['width'];
            $json["length"] = $rows['length'];
            $json["measure"] = $rows['measure'];
            $json["group"] = $rows['group'];
            $json["series"] = $rows['series'];
            $json["fabric"] = $rows['fabric'];
            $json["hem"] = $rows['hem'];
            $json["hemColor"] = $rows['hemColor'];
            $json["hemCaps"] = $rows['hemCaps'];
            $json["controlPosition"] = $rows['controlPosition'];
            $json["controlSystem"] = $rows['controlSystem'];
            $json["controlColorPower"] = $rows['controlColorPower'];
            $json["controlController"] = $rows['controlController'];
            $json["controlClutchMotor"] = $rows['controlClutchMotor'];
            $json["controlclutchCover"] = $rows['controlclutchCover'];
            $json["valance"] = $rows['valance'];
            $json["valanceFinish"] = $rows['valanceFinish'];
            $json["valanceCaps"] = $rows['valanceCaps'];
            $json["valanceReturn"] = $rows['valanceReturn'];
            $json["mount"] = $rows['mount'];
            $json["trim"] = $rows['trim'];
            $json["trimColor"] = $rows['trimColor'];
            $json["pull"] = $rows['pull'];
            $json["pullColor"] = $rows['pullColor'];
            $json["chainDrop"] = $rows['chainDrop'];
            $json["chainDropLength"] = $rows['chainDropLength'];
            $json["liftAssist"] = $rows['liftAssist'];
            $json["ultraLite"] = $rows['ultraLite'];
            $json["springAssist"] = $rows['springAssist'];
            $json["clutchColor"] = $rows['clutchColor'];
            $json["childSafety"] = $rows['childSafety'];
            $json["holdDownBrackets"] = $rows['holdDownBrackets'];
            $json["sideChannel"] = $rows['sideChannel'];
            $json["sideChannelMount"] = $rows['sideChannelMount'];
            $json["sideChannelFinish"] = $rows['sideChannelFinish'];
            $json["rollType"] = $rows['rollType'];
            $json["backGroup"] = $rows['backGroup'];
            $json["backSeries"] = $rows['backSeries'];
            $json["backFabric"] = $rows['backFabric'];
            $json["backHem"] = $rows['backHem'];
            $json["backhemFinish"] = $rows['backhemFinish'];
            $json["backHemCaps"] = $rows['backHemCaps'];
            $json["backCPosition"] = $rows['backCPosition'];
            $json["backCSystem"] = $rows['backCSystem'];
            $json["backCColorPower"] = $rows['backCColorPower'];
            $json["backCController"] = $rows['backCController'];
            $json["backCClutchMotor"] = $rows['backCClutchMotor'];
            $json["backChainDrop"] = $rows['backChainDrop'];
            $json["backChainDropLength"] = $rows['backChainDropLength'];
            $json["backClutchColor"] = $rows['backClutchColor'];
            $json["backChildSafety"] = $rows['backChildSafety'];
            $json["backSideChannel"] = $rows['backSideChannel'];
            $json["backSideChannelMount"] = $rows['backSideChannelMount'];
            $json["backSideChannelFinish"] = $rows['backSideChannelFinish'];
            $json["backRollType"] = $rows['backRollType'];
            $json["shade"] = $rows['shade'];
            
            $json["backGroup"]=$rows['backGroup'];
            $json["backSeries"]=$rows['backSeries'];
            $json["backFabric"]=$rows['backFabric'];
            $json["backHem"]=$rows['backHem'];
            $json["backHemFinish"]=$rows['backhemFinish'];
            $json["backHemCaps"]=$rows['backHemCaps'];
            $json["backCPosition"]=$rows['backCPosition'];
            $json["backCSystem"]=$rows['backCSystem'];
            $json["backCColorPower"]=$rows['backCColorPower'];
            $json["backCController"]=$rows['backCController'];
            $json["backCClutchMotor"]=$rows['backCClutchMotor'];
            $json["backChainDrop"]=$rows['backChainDrop'];
            $json["backChainDropLength"]=$rows['backChainDropLength'];
            $json["backClutchColor"]=$rows['backClutchColor'];
            $json["backChildSafety"]=$rows['backChildSafety'];
            $json["backSideChannel"]=$rows['backSideChannel'];
            $json["backSideChannelMount"]=$rows['backSideChannelMount'];
            $json["backSideChannelFinish"]=$rows['backSideChannelFinish'];
            $json["backRollType"]=$rows['backRollType'];

            $json["panel"]=$rows['panel'];
            $json["open"]=$rows['open'];
            $json["channel"]=$rows['channel'];

            // $optionName = $rows['colour'];
            // echo "<option value='$optionName'>$optionName</option>"; 
        }
    }
    // else
    // echo "<option value='N/A'>No Colours Available</option>"; 

    echo json_encode($json);



}
$conn->close();
?>