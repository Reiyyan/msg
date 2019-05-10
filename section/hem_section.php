<?php

    if($hem_name == ""){
        $hem_name="Accubar";
    }

    $hemquery = "SELECT Distinct hem_weight FROM _hem_type where hem_type = '$hem_name';";
    $hresult = $conn->query($hemquery);

    if ($hresult->num_rows == 1) {
        while($row = $hresult->fetch_assoc()) {
            $hem_weight = $row["hem_weight"];
        }
    } 
    else {
        echo "Couldn't find selected Bottom Bar, please contact Tech Support for details.";
    }

?>