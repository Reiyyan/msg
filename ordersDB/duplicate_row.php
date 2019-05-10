<?php
    // echo('BEFORE POST');

if ($_POST){

    require '../include/o_db.php';

    $reid = $_POST['reid'];
    $newReid = $_POST['nreid'];
    
    //Find current copy
    $result = $conn->query("SELECT * FROM order_entry WHERE reid = '$reid'");

    //Get its values
    $rows = $result->fetch_assoc();
    
    $shade = $rows['shade'];
    $price = $rows['price'];
    // Error if duplicate reid?
    // $reid = $rows['reid'];
    $orderTag = $rows['orderTag'];
    $shadeID = $rows['shadeID'];
    $quantity = $rows['quantity'];
    $width = $rows['width'];
    $length = $rows['length'];
    $measure = $rows['measure'];
    $group = $rows['group'];
    $series = $rows['series'];
    $fabric = $rows['fabric'];
    $hem = $rows['hem'];
    $hemColor = $rows['hemColor'];
    $hemCaps = $rows['hemCaps'];
    $controlPosition = $rows['controlPosition'];
    $controlSystem = $rows['controlSystem'];
    $controlColorPower = $rows['controlColorPower'];
    $controlController = $rows['controlController'];
    $controlClutchMotor = $rows['controlClutchMotor'];
    $controlclutchCover = $rows['controlclutchCover'];
    $valance = $rows['valance'];
    $valanceFinish = $rows['valanceFinish'];
    $valanceCaps = $rows['valanceCaps'];
    $valanceReturn = $rows['valanceReturn'];
    $mount = $rows['mount'];
    $trim = $rows['trim'];
    $trimColor = $rows['trimColor'];
    $pull = $rows['pull'];
    $pullColor = $rows['pullColor'];
    $chainDrop = $rows['chainDrop'];
    $chainDropLength = $rows['chainDropLength'];
    $liftAssist = $rows['liftAssist'];
    $ultraLite = $rows['ultraLite'];
    $springAssist = $rows['springAssist'];
    $clutchColor = $rows['clutchColor'];
    $childSafety = $rows['childSafety'];
    $holdDownBrackets = $rows['holdDownBrackets'];
    $sideChannel = $rows['sideChannel'];
    $sideChannelMount = $rows['sideChannelMount'];
    $sideChannelFinish = $rows['sideChannelFinish'];
    $rollType = $rows['rollType'];
    
    $stmt = mysqli_stmt_init($conn);

        $query = "INSERT INTO order_entry (reid, orderTag, shadeID, quantity, width, length, measure, `group`, series, fabric, hem, hemColor, hemCaps, controlPosition, controlSystem, controlColorPower, controlController, controlClutchMotor, controlclutchCover, valance, valanceFinish, valanceCaps, valanceReturn, mount, `trim`, trimColor, pull, pullColor, chainDrop, chainDropLength, liftAssist, ultraLite, springAssist, clutchColor, childSafety, holdDownBrackets, sideChannel, sideChannelMount, sideChannelFinish, rollType, shade, price) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        if(!mysqli_stmt_prepare($stmt, $query)){
            //CATCHES MISSING ERRORS HERE
            // header("Location: ../r2.html?error=ERROR REI SQL");
            // exit();
            echo("SQL ERROR MAN");
        }
        else{
            mysqli_stmt_bind_param($stmt, "sssiiisssssssssssssssssssssssisssssssssssd", $newReid,$orderTag,$shadeID,$quantity,$width,$length,$measure,$group,$series,$fabric,$hem,$hemColor,$hemCaps,$controlPosition,$controlSystem,$controlColorPower,$controlController,$controlClutchMotor,$controlClutchCover,$valance,$valanceFinish,$valanceCaps,$valanceReturn,$mount,$trim,$trimColor,$pull,$pullColor,$chainDrop,$chainDropLength,$liftAssist,$ultraLite,$springAssist,$clutchColor,$childSafety,$holdDownBrackets,$sideChannel,$sideChannelMount,$sideChannelFinish,$rollType, $shade, $price);
            mysqli_stmt_execute($stmt);

            echo ('Success Rei');

            // header("Location: ../r2.html?lineAdded=success");
            // exit();
        }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
?>