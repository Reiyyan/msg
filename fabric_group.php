<?php

include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

//Checking if Post is not null
if ($_POST){

//Assigning the Control Type Posted
$fabric_width = $_POST['fabric_width'];
$railroad = $_POST['railroad'];
$shade = strtolower($_POST['shade']);

//If it Control Type is not Null and not Neo Then go
if ( $fabric_width != 'null' ){

    if($shade == "roller shade" || $shade == "fixed shade" || $shade == "vision shade" || $shade == "gemini dual shade"){

        if($railroad == 'false' ){
            $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') AND Width >= '$fabric_width' ORDER BY `group` Asc;";

            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Group―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['group'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND (category != 'Fabric Interlude' OR category != 'Fabric Illusion') AND railroad = true ORDER BY `group` Asc;";
            
            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Fabric―</option>');
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['group'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }

        }
    }

    else if($shade == "interlude shade"){

        $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND category = 'Fabric Interlude' AND Width >= '$fabric_width' ORDER BY `group` Asc;";
        echo $query;

        $resultSet = $conn->query($query);
        
        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled value="N/A">―Select Your Group―</option>');
        
        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['group'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
        
    }

    else if($shade == "illusion shade"){

        $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND category = 'Fabric Illusion' AND Width >= '$fabric_width' ORDER BY `group` Asc;";
        echo $query;


        $resultSet = $conn->query($query);
        
        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled value="N/A">―Select Your Group―</option>');
        
        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['group'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
        
    }

    else if($shade == "roman shade"){
        $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') AND Width >= '$fabric_width' AND `roman` = 1 ORDER BY `group` Asc;";

        $resultSet = $conn->query($query);
        
        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled value="N/A">―Select Your Group―</option>');
        
        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['group'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }

    else if($shade == "panel track"){

        if($railroad == 'false' ){
            $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') ORDER BY `group` Asc;";

            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Group―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['group'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $query = "SELECT DISTINCT `group` FROM _fabric WHERE `group` IS NOT NULL AND Active = true AND (category != 'Fabric Interlude' OR category != 'Fabric Illusion') AND railroad = true ORDER BY `group` Asc;";
            
            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Fabric―</option>');
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['group'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }

        }
    }

    /*if($shade == "interlude shade"){
        
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
    }*/

    /*if($shade == "illusion shade"){
        
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
    }*/
}


}



?>
