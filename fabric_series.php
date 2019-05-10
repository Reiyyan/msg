<?php

include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

//Checking if Post is not null
if ($_POST){

//Assigning the Control Type Posted
$fabric_width = $_POST['fabric_width'];
$railroad = $_POST['railroad'];
$shade = strtolower($_POST['shade']);
$group = $_POST['group'];

//If it Control Type is not Null and not Neo Then go
if ( $fabric_width != 'null' ){

    if($shade == "roller shade" || $shade == "fixed shade" || $shade == "vision shade" || $shade == "gemini dual shade"){

        if($railroad == 'false' ){

            $query = "SELECT DISTINCT `series` FROM  _fabric WHERE `group` = '$group' AND Width >= '$fabric_width' AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') ORDER BY `series` Asc;";

            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Series―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['series'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $query = "SELECT DISTINCT `series` FROM  _fabric WHERE `group` = '$group' AND railroad = true AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') ORDER BY `series` Asc;";
            
            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Fabric―</option>');
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['series'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }

        }
    }

    if($shade == "interlude shade"){

        $query = "SELECT DISTINCT `series` FROM  _fabric WHERE `group` = '$group' AND Width >= '$fabric_width' AND Active = true AND category = 'Fabric Interlude' ORDER BY `series` Asc;";

        $resultSet = $conn->query($query);
        
        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled value="N/A">―Select Your Series―</option>');
        
        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['series'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }

    if($shade == "illusion shade"){
        
        $query = "SELECT DISTINCT `series` FROM  _fabric WHERE `group` = '$group' AND Width >= '$fabric_width' AND Active = true AND category = 'Fabric Illusion' ORDER BY `series` Asc;";

        $resultSet = $conn->query($query);
        
        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled value="N/A">―Select Your Series―</option>');
        
        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['series'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }
    else if($shade == "roman shade"){
        $query = "SELECT DISTINCT `series` FROM _fabric WHERE `group` = '$group' AND Width >= '$fabric_width' AND Active = true AND `roman` = 1 ORDER BY `series` Asc;";
        echo $query;
        $resultSet = $conn->query($query);
        
        $row_cnt = $resultSet->num_rows;

        echo ('<option disabled value="N/A">―Select Your Group―</option>');
        
        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionName = $rows['series'];
                        echo "<option value='$optionName'>$optionName</option>"; 
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }

    else if($shade == "panel track"){

        if($railroad == 'false' ){

            $query = "SELECT DISTINCT `series` FROM  _fabric WHERE `group` = '$group' AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') ORDER BY `series` Asc;";

            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Series―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['series'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $query = "SELECT DISTINCT `series` FROM  _fabric WHERE `group` = '$group' AND railroad = true AND (category != 'Fabric Interlude' AND category != 'Fabric Illusion') ORDER BY `series` Asc;";
            
            $resultSet = $conn->query($query);
            
            $row_cnt = $resultSet->num_rows;

            echo ('<option disabled value="N/A">―Select Your Fabric―</option>');
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionName = $rows['series'];
                            echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }

        }
    }
}

}



?>
