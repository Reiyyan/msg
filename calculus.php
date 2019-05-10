<?php

function deflectionCalculus($fWidth, $fLength, $fWeight, $tube_weight, $hWeight, $inertia){
    $d;
 /*  echo 'Variables <br>';
    echo 'Fabric Width: '. $fWidth .'<br>';
    echo 'Fabric Weight: '. $fWeight .'<br>';
    echo 'Fabric Length: '. $fLength .'<br>';
    echo 'Tube Weight: '. $tube_weight .'<br>';
    echo 'Hem Weight: '. $hWeight .'<br>';
    echo 'Inertia: '. $inertia .'<br>';
    echo '<br>';
 */
    $d = ($fWidth**3 * ($fWeight * ($fLength + 12) + $tube_weight + $hWeight))/(384000 * $inertia);
    return $d;
}

function checkTube($tubes, $deflection, $admissable){
    for($i = 0; $i<= sizeof($admissable)-1; $i++){
        global $δ;
        global $possibleDeflectionTubes;
        //echo ' <br> In Tube: ' .$tubes[$i]["name"]. "<br>";
        if($deflection[$i] < $δ && $admissable{$i}){
            //echo 'This Tube Works in ' . $tubes[$i]["name"]. "<br>";
            array_push($possibleDeflectionTubes, $i);
           // echo 'Pushing Tube of Index ' . $i;
            $tubesIndex = $i;
            //return selectTube($i);
        }
        else if(sizeof($admissable) == 0){
            print_r($admissable);
            echo "No Tubes Work";
        }

    }
}

function selectTube($index){

    global $tube_0;
    global $tube_1;
    global $tube_2;
    global $tube_3;
    global $tube_4;
    global $tube_5;
    global $tube_6;
    global $tube_7;

    switch($index){
        case 0:
            return $tube_0;
            break;
        case 1:
            return $tube_1;
            break;
        case 2:
            return $tube_2;
            break;
        case 3:
            return $tube_3;
            break;
        case 4:
            return $tube_4;
            break;
        case 5:
            return $tube_5;
            break;
        case 6:
            return $tube_6;
            break;
        case 7:
            return $tube_7;
            break; 
        default:
            return null;
            break;
    }
}

function calculateRUD($flength, $fthickness, $tradius){

    $⌀ = 2 * (($tradius**2 + (($flength+12) * $fthickness)/pi()) ** (1/2));
    //echo "<br>RUD is: " .$⌀;
    return $⌀;
}

function calculateTorque($fwidth, $flength, $fweight, $hweight, $tradius){
    global $forceConversion;
    $τ = (($fweight * ($flength+12) + $hweight ) * $fwidth * $tradius) * $forceConversion;
    //echo "<br>Torque is: " .$τ;
    return $τ;
}

function finalizeTubes($control , $array){

    switch ($control){
        case 'Chain':
            return $array[0];
            break;
        case 'Cord':
            return $array[0];
            break;
        case 'Neo':
            return end($array);
            break;

        case 'Motor':
            return $array[0];
            break;

        case 'Chain - Vision':
            return $array[0];
            break;
        default:
            return "Error In Finalizing Tube";
    }

}

function pickNeo($neo_options){
    if($neo_options == 'Neo 1.5'){
        return 2;
    }
    else{
        return 0;
    }
}

?>