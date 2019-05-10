<?php

    $b_fabricWeight = $fabric_width * ($fabric_length+12) * $fabric_weight;
    echo $b_fabricWeight;
    echo ('<br>');
    $b_hemWeight = $fabric_width * $hem_weight;
    echo $b_hemWeight;
    echo ('<br>');
    $b_fabricTorque = $b_fabricWeight * $selectedTube->tube_radius;
    echo $b_fabricTorque;
    echo ('<br>');
    $b_hemTorque = $b_hemWeight * $selectedTube->tube_radius;
    echo $b_hemTorque;
    echo ('<br>');

    $blind_torque = $b_fabricTorque + $b_hemTorque;
    echo "blind_torque";
    echo $blind_torque;
    echo ('<br>');

    $b_turns = (sqrt ( ($fabric_length+12) * $fabric_thickness / 3.14159265359 + 
    $selectedTube->tube_radius**2) - $selectedTube->tube_radius ) / $fabric_thickness;
    echo $b_turns;
    echo ('<br>');
    
    echo ('Tpt: ');
    $tpt = $b_fabricTorque/$b_turns;
    echo $tpt;
    echo ('<br>');
    
    $spring;
    if($tpt/0.15 == 0 && $blind_torque > 1.4){
        $spring = 15;
    }
    else{
        $spring = ceil($tpt/0.15) * 15;
    }
    echo "V".$spring;
    echo ('<br>');

    $spring_turns;
    if($spring == 0){
        $spring_turns = 1;
    }
    else{
        $spring_turns = (($b_hemTorque+0.08)/($spring/100));
    }
    echo $spring_turns;
    echo ('<br>');

?>