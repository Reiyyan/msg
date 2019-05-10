<?php

include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

//Checking if Post is not null
if ($_POST){

//Assigning the Control Type Posted
$fabric_width = $_POST['fabric_width'];
$series = $_POST['series'];
$railroad = $_POST['railroad'];
$shade = strtolower($_POST['shade']);

echo $shade;
echo $railroad;

//If it Control Type is not Null and not Neo Then go
if ( $fabric_width != 'null' ){

    if($shade == "roller shade" || $shade == "fixed shade"){

        if($railroad == 'false' ){

            $resultSet = $conn->query("SELECT * FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND series = '$series' ORDER BY Colour Asc;");

            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['Colour'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $resultSet = $conn->query("SELECT Description FROM _fabric where railroad = true AND active = true AND = '$series' ORDER BY Colour Asc;");
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['Colour'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }

        }
    }

    if($shade == "interlude shade"){
        
        $resultSet = $conn->query("SELECT Description FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND category = 'Fabric Interlude' ORDER BY Description Asc;");

        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');

        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['Description'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }

    if($shade == "illusion shade"){
        
        $resultSet = $conn->query("SELECT Description FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND category = 'Fabric Illusion' ORDER BY Description Asc;");

        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');

        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['Description'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }
}


}



?>
