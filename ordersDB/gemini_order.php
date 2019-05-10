<?php
    // echo('BEFORE POST');
    session_start();
    $email = $_SESSION['email'];
    $purchaseOrder = $_SESSION['purchaseOrder'];

if ($_POST){
    // echo('GOT HERE');

    require '../include/o_db.php';

    $reid = $_POST['reid'];
    $orderTag = $_POST['orderTag'];
    $shadeID = $_POST['shadeID'];
    $quantity = $_POST['quantity'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $measure = $_POST['measure'];
    $group = $_POST['group'];
    $series = $_POST['series'];
    $fabric = $_POST['fabric'];
    $hem = $_POST['hem'];
    $hemColor = $_POST['hemColor'];
    $hemCaps = $_POST['hemCaps'];
    $stitched = $_POST['stitched'];
    $controlPosition = $_POST['controlPosition'];
    $controlSystem = $_POST['controlSystem'];
    $controlColorPower = $_POST['controlColorPower'];
    $controlController = $_POST['controlController'];
    $controlClutchMotor = $_POST['controlClutchMotor'];
    // $controlClutchCover = $_POST['controlClutchCover'];
    $valance = $_POST['valance'];
    $valanceFinish = $_POST['valanceFinish'];
    $valanceCaps = $_POST['valanceCaps'];
    // $valanceReturn = $_POST['valanceReturn'];
    $mount = $_POST['mount'];
    // $trim = $_POST['trim'];
    // $trimColor = $_POST['trimColor'];
    // $pull = $_POST['pull'];
    // $pullColor = $_POST['pullColor'];
    $chainDrop = $_POST['chainDrop'];
    $chainDropLength = $_POST['chainDropLength'];
    // $liftAssist = $_POST['liftAssist'];
    // $ultraLite = $_POST['ultraLite'];
    // $springAssist = $_POST['springAssist'];
    $clutchColor = $_POST['clutchColor'];
    $childSafety = $_POST['childSafety'];
    // $holdDownBrackets = $_POST['holdDownBrackets'];
    // $sideChannel = $_POST['sideChannel'];
    // $sideChannelMount = $_POST['sideChannelMount'];
    // $sideChannelFinish = $_POST['sideChannelFinish'];
    $rollType = $_POST['rollType'];

    $backGroup = $_POST['back_group'];
    $backSeries = $_POST['back_series'];
    // "back_fabric": back_selectedFabric,
    $backFabric = $_POST['back_fabric'];
    $backHem = $_POST['back_hem'];
    $backhemFinish = $_POST['back_hemColor'];
    $backHemCaps = $_POST['back_hemCaps'];
    $backStitched = $_POST['stitched'];
    $backCPosition = $_POST['back_controlPosition'];
    $backCSystem = $_POST['back_controlSystem'];
    $backCColorPower = $_POST['back_controlColorPower'];
    $backCController = $_POST['back_controlController'];
    $backCClutchMotor = $_POST['back_controlClutchMotor'];
    $backChainDrop = $_POST['back_chainDrop'];
    $backChainDropLength = $_POST['back_chainDropCustom'];
    $backClutchColor = $_POST['back_clutchColor'];
    $backChildSafety = $_POST['back_childSafety'];
    $backSideChannel = $_POST['sideChannels'];
    $backSideChannelMount = $_POST['sideChannelMount'];
    $backSideChannelFinish = $_POST['sideChannelFinish'];
    $backRollType = $_POST['back_rollType'];

    // sideChannels": document.getElementById('side_channels').value,
    // "sideChannelMount": selectedSCMount,
    // "sideChannelFinish"


    // "back_group": document.getElementById('back_fabric_group').value,
    // "back_series": document.getElementById('back_fabric_series').value,
    // "back_fabric": back_selectedFabric,
    // "back_hem": back_selectedHem,
    // "back_hemColor": document.getElementById('back_hem_finish').value,
    // "back_hemCaps": document.getElementById('back_hem_caps').value,
    // "back_controlPosition": document.getElementById('back_control_position').value,
    // "back_controlSystem": document.getElementById('back_control_system').value,
    // "back_controlColorPower": document.getElementById('back_control_power').value,
    // "back_controlController": document.getElementById('back_control_controller').value,
    // "back_controlClutchMotor": document.getElementById('back_motor_clutch').value,
    // "back_clutchCover": document.getElementById('back_c_bracket').checked,
    // "back_chainDrop": document.getElementById('back_chain_length').value,
    // "back_chainDropCustom": document.getElementById('back_drop').value,
    // "back_clutchColor": document.getElementById('back_clutch_colour').value,
    // "back_childSafety": back_selectedSafety,
    // "back_rollType": back_selectedRoll

    $shade = $_POST['shade'];
    $price = $_POST['price'];

    //Check if row already exists
    $query = "SELECT reid FROM  order_entry WHERE reid = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../gemini.html?error=sqlerror");
        exit();
    }
    //If it exists, delete it
    else{
        mysqli_stmt_bind_param($stmt, "s", $reid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if($resultCheck == 1){
            // $stmt = mysqli_stmt_init($conn);
            $query = "DELETE FROM order_entry WHERE `reid` = '$reid'";
            $myresult = $conn->query($query);
            // echo ("deleting row");
        }
    }
        // then insert new row

        $stmt = mysqli_stmt_init($conn);

        $query = "INSERT INTO order_entry (email, reid, orderTag, shadeID, quantity, width, length, measure, `group`, series, fabric, hem, hemColor, hemCaps, hemStitched, controlPosition, controlSystem, controlColorPower, controlController, controlClutchMotor, controlclutchCover, valance, valanceFinish, valanceCaps, valanceReturn, mount, `trim`, trimColor, pull, pullColor, chainDrop, chainDropLength, liftAssist, ultraLite, springAssist, clutchColor, childSafety, holdDownBrackets, sideChannel, sideChannelMount, sideChannelFinish, rollType, shade, price, backGroup, backSeries, backFabric, backHem, backhemFinish, backHemCaps, backStitched, backCPosition, backCSystem, backCColorPower, backCController, backCClutchMotor, backChainDrop, backChainDropLength, backClutchColor, backChildSafety, backSideChannel, backSideChannelMount, backSideChannelFinish, backRollType, PO) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        if(!mysqli_stmt_prepare($stmt, $query)){
            //CATCHES MISSING ERRORS HERE
            // header("Location: ../r2.html?error=ERROR REI SQL");
            // exit();
            echo("Gemini Prep Failed");
        }
        else{
            mysqli_stmt_bind_param($stmt, "ssssiddssssssssssssssssssssssssisssssssssssdsssssssssssssisssssss", $email, $reid,$orderTag,$shadeID,$quantity,$width,$length,$measure,$group,$series,$fabric,$hem,$hemColor,$hemCaps, $stitched,$controlPosition,$controlSystem,$controlColorPower,$controlController,$controlClutchMotor,$controlClutchCover,$valance,$valanceFinish,$valanceCaps,$valanceReturn,$mount,$trim,$trimColor,$pull,$pullColor,$chainDrop,$chainDropLength,$liftAssist,$ultraLite,$springAssist,$clutchColor,$childSafety,$holdDownBrackets,$sideChannel,$sideChannelMount,$sideChannelFinish,$rollType, $shade, $price, $backGroup,$backSeries,$backFabric,$backHem,$backhemFinish,$backHemCaps, $backStitched, $backCPosition,$backCSystem,$backCColorPower,$backCController,$backCClutchMotor,$backChainDrop,$backChainDropLength,$backClutchColor,$backChildSafety,$backSideChannel,$backSideChannelMount,$backSideChannelFinish,$backRollType, $purchaseOrder);
            mysqli_stmt_execute($stmt);
            echo ('Gemini Success Rei');

            // header("Location: ../r2.html?lineAdded=success");
            // exit();
        }


            //Adding TAG/Name to Order Table

    $query = "SELECT orderTag FROM order_tag WHERE orderTag = ?";
    $stmt = mysqli_stmt_init($conn);
    // echo($query);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../roller.html?error=sqlerror");
        exit();
    }
    //If it exists, error
    else{
        mysqli_stmt_bind_param($stmt, "s", $orderTag);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        
        if($resultCheck != 0){
            // header("Location: ../orders.html?name=exists");
            echo($query);
            echo("Order Exists, not making new");
        }
        else{
            // then insert new row
            $stmt = mysqli_stmt_init($conn);

            // $query = "INSERT INTO order_tag (orderTag, `date`, `email`) VALUES ('$orderTag', '$sg_date', '$email');";
            // $result = $conn->query($query);

            $query = "INSERT INTO order_tag (orderTag, `date`, `email`, `PO`) VALUES (?,?,?,?);";
            if(!mysqli_stmt_prepare($stmt, $query)){
                //CATCHES MISSING ERRORS HERE
                // header("Location: ../r2.html?error=ERROR REI SQL");
                // exit();
                echo("Error in Order Query");
            }
            else{
                $sg_date = date("Y-m-d");
                mysqli_stmt_bind_param($stmt, "ssss", $orderTag, $sg_date, $email, $purchaseOrder);
                mysqli_stmt_execute($stmt);
                echo("OTHER SUCCESS");
                // echo ('Success Rei');
                // header("Location: ../r2.html?lineAdded=success");
                // exit();
            }
        }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
}
//else If No Post
else{
    echo ('Failed Rei');

    header("Location: ../gemini.html?result=FailedPost");
    exit();
}


?>