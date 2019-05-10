<?php
header('Content-type: text/javascript');

include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Variables

        $shade = strtolower($_POST['shade']);

        $width = $_POST['fabric_width'];
        $length = $_POST['fabric_length'];
        $fabric_name = $_POST['fabric_name'];
        $price_group = $_POST['price_group'];
        $i_width = $_POST['i_width'];
        $p_width = $_POST['p_width'];
        $p_length =  $_POST['p_length'];
        $fabric_price = 0;

        $drive = $_POST['motor_clutch'];
        $control_system = $_POST['control_system'];
        
        $lift_assist = $_POST['lift_assist'];
        $lam_price = 0;
        
        //$multiband;

        $drive_price = 0;

        $valance = $_POST['valance_type'];
        $valance_price = 0;

        $channels = $_POST['channels'];
        $side_price = 0;
        $bottom_price;
        $channel_price = 0;

        $trim_w = $_POST['trim_w'];
        $trim = $_POST['trim'];
        $trim_price = 0;

        $pull = $_POST['pull'];
        $pull_price = 0;

        $discount = 0;

        session_start();
        if(isset($_SESSION['discount'])){
            $discount = $_SESSION['discount'];
        }
        

        /*
        multiband
        */
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Fabric Price
    if(!is_null($fabric_name)){

        if($shade == 'roller shade' || $shade == 'gemini dual shade'){

            $fQuery = "SELECT `$width` FROM `_roller_pg_$price_group` WHERE length = $length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$width"];
                    
                }
            }
        }

        else if($shade == 'interlude shade'){

            if($length > 120){
                $length = 120;
            }

            $fQuery = "SELECT `$i_width` FROM `_int_pg_$price_group` WHERE length = $length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$i_width"];
                    
                }
            }
        }

        else if($shade == 'illusion shade'){

            if($i_width > 102){
                $i_width = 102;
            }
            if($length > 120){
                $length = 120;
            }

            $fQuery = "SELECT `$i_width` FROM `_ill_pg_$price_group` WHERE length = $length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$i_width"];
                    
                }
            }
        }
        else if($shade == 'vision shade'){
            $fQuery = "SELECT `$width` FROM `_vision_pg_$price_group` WHERE length = $length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$width"];
                    
                }
            }
        }
        else if($shade == 'roman shade'){
            $fQuery = "SELECT `$width` FROM `_roman_pg_$price_group` WHERE length = $length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$width"];
                    
                }
            }
        }
        else if($shade == 'panel track'){
            $fQuery = "SELECT `$p_width` FROM `_panel_pg_$price_group` WHERE length = $p_length;";
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$p_width"];
                }
            }
        }
        else if($shade == 'fixed shade'){
            $fQuery = "SELECT `$width` FROM `_fixed_pg_$price_group` WHERE length = $length;";            
            //echo $fQuery;
            //echo '<br>';
            $fResult = $conn->query($fQuery);
            if ($fResult->num_rows == 1) {
                
                // output data of each row
                while($row = $fResult->fetch_assoc()) {
                    $fabric_price = $row["$width"];
                    
                }
            }
        }
        
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Drive Price
    if($control_system == 'Motor'){
        if(!is_null($drive)){
        $dQuery = "SELECT price FROM _drive_price WHERE drive = '$drive';";
        //echo $dQuery;
        //echo '<br>';
        $dResult = $conn->query($dQuery);
            if ($dResult->num_rows == 1) {
                
                // output data of each row
                while($row = $dResult->fetch_assoc()) {
                    $drive_price = $row["price"];
                    
                }
            }
        }
    }
    else if($control_system == 'Neo'){
        if ($valance == "Decora 8" || $valance ==  "Decora 12" || $valance ==  "Decora 16" ){
            $drive = 'Neo Decora';
            $dQuery = "SELECT price FROM _drive_price WHERE drive = '$drive';";
            //echo $dQuery;
            //echo '<br>';
            $dResult = $conn->query($dQuery);
                
            if ($dResult->num_rows == 1) {
                    
                // output data of each row
                while($row = $dResult->fetch_assoc()) {
                    $drive_price = $row["price"]; 
                }
            }  
        }
        else{
            $drive = 'Neo Open';
            $dQuery = "SELECT price FROM _drive_price WHERE drive = '$drive';";
            //echo $dQuery;
            //echo '<br>';
            $dResult = $conn->query($dQuery);
                
            if ($dResult->num_rows == 1) {
                    
                // output data of each row
                while($row = $dResult->fetch_assoc()) {
                    $drive_price = $row["price"]; 
                }
            } 
        }

    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Valance Price
    if(!is_null($valance)){
        //TODO FIX WIDTH HERE
    if($width <= 192){
        $vQuery = "SELECT `$width` FROM _valance_price WHERE Valance = '$valance';";
        //echo $vQuery;
        //echo '<br>';
        $vResult = $conn->query($vQuery);

        if ($vResult->num_rows == 1) {
            
            // output data of each row
            while($row = $vResult->fetch_assoc()) {
                $valance_price = $row["$width"];
                
            }
        }
    }
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Lift Assist
    if(!is_null($lift_assist)){
        if($lift_assist == 'Ultra Lite'){   
            $lQuery = "SELECT price FROM _lift_assist where id_lift_assist = 1;";
            //echo $lQuery;
            //echo '<br>';
            $lResult = $conn->query($lQuery);
            if ($lResult->num_rows == 1) {
                
                // output data of each row
                while($row = $lResult->fetch_assoc()) {
                    $lam_price = $row["price"];  
                }
            }
        }
        else if($lift_assist == 'Spring Assist'){   
            $lQuery = "SELECT price FROM _lift_assist where id_lift_assist = 2;";
            //echo $lQuery;
            //echo '<br>';
            $lResult = $conn->query($lQuery);
            if ($lResult->num_rows == 1) {
                
                // output data of each row
                while($row = $lResult->fetch_assoc()) {
                    $lam_price = $row["price"];  
                }
            }
        }
        else{
            $lam_price = 0;
        }
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Side & Bottom Channels
    if(!is_null($channels)){
        if($channels == 'Side Channels'){   
            $sQuery = "SELECT `$length` FROM `_side_prices` WHERE Side_Channel = 'Side Channel';";
            //echo $sQuery;
            //echo '<br>';
            $sResult = $conn->query($sQuery);
            if ($sResult->num_rows == 1) {
                
                // output data of each row
                while($row = $sResult->fetch_assoc()) {
                    $side_price = $row["$length"];  
                }
            }
            $channel_price = $side_price;
        }
        else if($channels == 'Side & Bottom Channels'){
            //Side
            $sQuery = "SELECT `$length` FROM `_side_prices` WHERE Side_Channel = 'Side Channel';";
            //echo $sQuery;
            //echo '<br>';
            $sResult = $conn->query($sQuery);
            if ($sResult->num_rows == 1) {
                
                // output data of each row
                while($row = $sResult->fetch_assoc()) {
                    $side_price = $row["$length"];  
                }
            }
            
            //Bottoms
            $bQuery = "SELECT `$width` FROM `_bottom_prices` WHERE Bottom_Channel = 'Bottom Channel';";
            //echo $bQuery;
            //echo '<br>';
            $bResult = $conn->query($bQuery);
            if ($bResult->num_rows == 1) {
                
                // output data of each row
                while($row = $bResult->fetch_assoc()) {
                    $bottom_price = $row["$width"];  
                }
            }

            $channel_price = $bottom_price + $side_price;
            
        }
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
//Trims & Pulls
    if(!is_null($trim)){
            $tQuery = "SELECT `$trim_w` FROM _trim WHERE Trim = '$trim';";
            //echo $tQuery;
            //echo '<br>';
            $tResult = $conn->query($tQuery);

            if ($tResult->num_rows == 1) {
                
                // output data of each row
                while($row = $tResult->fetch_assoc()) {
                    $trim_price = $row["$trim_w"];
                    
                }
            }
    }

    if(!is_null($pull)){
        $pQuery = "SELECT price FROM _pull WHERE pull = '$pull';";
        //echo $pQuery;
        //echo '<br>';
        $pResult = $conn->query($pQuery);

        if ($pResult->num_rows == 1) {
            
            // output data of each row
            while($row = $pResult->fetch_assoc()) {
                $pull_price = $row["price"];
                
            }
        }
    }
/*---------------------------------------------------------------------------------------------------------------------------------------*/
if($shade == "illusion shade"){
    $total = $fabric_price + $drive_price;
}
else{
    $total = $fabric_price + $drive_price + $valance_price + $trim_price + $pull_price + $side_price + $channel_price + $lam_price;
}

$json = array('discount' => $discount, 'total' => $total, 'lam' => $lam_price, 'Fabric' => $fabric_price);

/*//echo '<br>';
//echo 'Fabric Price: ' .$fabric_price;
//echo '<br>';
//echo 'Drive Price: ' .$drive_price;
//echo '<br>';
//echo 'Valance Price: ' .$valance_price;
//echo '<br>';
//echo 'Channels Price: ' . $channel_price;
//echo '<br>';
//echo 'Total Price: ' .$total;*/

echo json_encode($json);      
}
$conn->close();
?>