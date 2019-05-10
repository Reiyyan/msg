<?php

    //Fabric Query
    $fabricquery = "SELECT Description, Thickness, Weight FROM _fabric where description = '$fabric_name';";
    $fresult = $conn->query($fabricquery);
    
    if ($fresult->num_rows == 1) {
        while($row = $fresult->fetch_assoc()) {
            $fabric_name = $row["Description"];
            $fabric_thickness = $row["Thickness"];
            $fabric_weight = $row["Weight"];
        }
    } 
    else {
        echo "Couldn't find selected Fabric, please contact Tech Support for details.";
    }

?>