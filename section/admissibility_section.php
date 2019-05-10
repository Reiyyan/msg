<?php

// Ignoring Valance as it blocks tubes/motors from being picked in reverse.
// if(($valance == null) || ($valance =="")){
//     $valance="Any";
// }
$valance="Any";


$admArray;
$sysAdmArray = array();

$admquery = "SELECT Valance, `1_Inch`, `1.125_Inch`, `1.5_Inch`, `2_Inch`, `2.5_inch`, `3_inch`, `J_tube`, `i_tube` FROM _tube_compatibility Where Valance = '$valance';";

$admresult = $conn->query($admquery);

if ($admresult->num_rows == 1) {


    while($row = $admresult->fetch_assoc()) {
        $admArray = array(
            $row['1_Inch'],
            $row['1.125_Inch'],
            $row['1.5_Inch'],
            $row['2_Inch'],
            $row['2.5_inch'],
            $row['3_inch'],
            $row['J_tube'],
            $row['i_tube']
        );
    }
}

$sysQuery = "SELECT `1_Inch`, `1.125_Inch`, `1.5_Inch`, `2_Inch`, `2.5_inch`, `3_inch`, `J_tube`, `i_tube` FROM _tube_system_compatibility where System = '$shade';";

$sysResult = $conn->query($sysQuery);

if ($sysResult->num_rows == 1) {
    while($row = $sysResult->fetch_assoc()) {

        foreach ($row as &$value) {
        //    echo $value;
        //    echo '<br>';
           if(!is_null($value)){
            array_push($sysAdmArray, $value);
        }
        }
        // echo '<br>';
        // print_r ($sysAdmArray);
        // echo '<br>';

    }
}


//print_r($admArray);


?>