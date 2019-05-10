<?php

include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

//Checking if Post is not null
if ($_POST){

//Assigning the Control Type Posted
$fabric_width = $_POST['fabric_width'];
$group = $_POST['group'];
$series = $_POST['series'];
$railroad = $_POST['railroad'];
$shade = strtolower($_POST['shade']);

// echo $shade;
// echo $railroad;

//If it Control Type is not Null and not Neo Then go
if ( $fabric_width != 'null' ){

    if($shade == "roller shade" || $shade == "fixed shade" || $shade == "vision shade" || $shade == "gemini dual shade"){

        if($railroad == 'false' ){

            // $myquery = "SELECT Description, image, Colour FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND series = '$series' AND `group` = '$group' ORDER BY Colour Asc;";
            // echo $myquery;

            $resultSet = $conn->query("SELECT Description, image, Colour FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND series = '$series' AND `group` = '$group' ORDER BY Colour Asc;");

            

            $row_cnt = $resultSet->num_rows;

            // echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionColour = strtolower($rows['Colour']);
                            $optionDesc = $rows['Description'];
                            $optionURL = $rows['image'];

                            //echo "$optionURL$optionColour.jpg";

                        echo("
                        <div class='sg-box'>
                            <div>
                                <label for='$optionDesc'> 
                                <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                        <span class='check-text'>$optionColour</span>                                
                                        <span class='sg-check'></span>
                                </label>
                            </div>
                        </div>
                        ");
                            
                            // echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $resultSet = $conn->query("SELECT * FROM _fabric WHERE railroad = true AND Active = true AND series = '$series' AND `group` = '$group' ORDER BY Colour Asc;");
            
            $row_cnt = $resultSet->num_rows;

            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionColour = strtolower($rows['Colour']);
                            $optionDesc = $rows['Description'];
                            $optionURL = $rows['image'];

                            echo("
                                <div class='sg-box'>
                                    <label for='$optionDesc'> 
                                        <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                            <span class='check-text'>$optionColour</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                </div>
                            ");
                        
                        }
            
                if($row_cnt == 0){
                    echo "No Fabrics Available In Selected Size"; 
                }

        }
    }
    else if($shade == "interlude shade"){
        
        $resultSet = $conn->query("SELECT Description, image, Colour FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND category = 'Fabric Interlude' AND series = '$series' AND `group` = '$group' ORDER BY Description Asc;");
        

        $row_cnt = $resultSet->num_rows;

        //echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');

        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionColour = strtolower($rows['Colour']);
                        $optionDesc = $rows['Description'];
                        $optionURL = $rows['image'];

                        //echo "$optionURL$optionColour.jpg";

                        echo("
                            <div class='sg-box'>
                            <div>
                                <label for='$optionDesc'> 
                                    <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                        <span class='check-text'>$optionColour</span>                                
                                        <span class='sg-check'></span>
                                </label>
                            </div>
                        </div>
                        ");
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }
    else if($shade == "illusion shade"){
        
        $resultSet = $conn->query("SELECT Description, image, Colour FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND category = 'Fabric Illusion' AND series = '$series' AND `group` = '$group' ORDER BY Description Asc;");

        $row_cnt = $resultSet->num_rows;

        //echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');

        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionColour = strtolower($rows['Colour']);
                        $optionDesc = $rows['Description'];
                        $optionURL = $rows['image'];

                        //echo "$optionURL$optionColour.jpg";

                        echo("
                            <div class='sg-box'>
                            <div>
                                <label for='$optionDesc'> 
                                    <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                        <span class='check-text'>$optionColour</span>                                
                                        <span class='sg-check'></span>
                                </label>
                            </div>
                        </div>
                        ");
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }
    else if($shade == "roman shade"){
        
        $resultSet = $conn->query("SELECT Description, image, Colour FROM _fabric WHERE Width >= '$fabric_width' AND Active = true AND series = '$series' AND `group` = '$group' AND `roman` = 1 ORDER BY Description Asc;");

        $row_cnt = $resultSet->num_rows;

        //echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');

        while($rows = $resultSet->fetch_assoc())
                    {
                        $optionColour = strtolower($rows['Colour']);
                        $optionDesc = $rows['Description'];
                        $optionURL = $rows['image'];

                        //echo "$optionURL$optionColour.jpg";

                        echo("
                            <div class='sg-box'>
                            <div>
                                <label for='$optionDesc'> 
                                    <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                        <span class='check-text'>$optionColour</span>                                
                                        <span class='sg-check'></span>
                                </label>
                            </div>
                        </div>
                        ");
                    }
        
            if($row_cnt == 0){
                echo "<option value='N/A'>No Fabrics Available</option>"; 
            }
    }
    else if($shade == "panel track"){

        if($railroad == 'false' ){

            $resultSet = $conn->query("SELECT Description, image, Colour FROM _fabric WHERE Active = true AND series = '$series' AND `group` = '$group' ORDER BY Colour Asc;");

            $row_cnt = $resultSet->num_rows;

            // echo ('<option disabled selected value="Select Your Fabric">―Select Your Fabric―</option>');
            
            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionColour = strtolower($rows['Colour']);
                            $optionDesc = $rows['Description'];
                            $optionURL = $rows['image'];

                            //echo "$optionURL$optionColour.jpg";

                        echo("
                        <div class='sg-box'>
                            <div>
                                <label for='$optionDesc'> 
                                <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                </label>
                                <label class='sg-swatch-label'>
                                        <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                        <span class='check-text'>$optionColour</span>                                
                                        <span class='sg-check'></span>
                                </label>
                            </div>
                        </div>
                        ");
                            
                            // echo "<option value='$optionName'>$optionName</option>"; 
                        }
            
                if($row_cnt == 0){
                    echo "<option value='N/A'>No Fabrics Available</option>"; 
                }
        }

        if($railroad == 'true' ){

            $resultSet = $conn->query("SELECT * FROM _fabric WHERE railroad = true AND Active = true AND series = '$series' AND `group` = '$group' ORDER BY Colour Asc;");
            
            $row_cnt = $resultSet->num_rows;

            while($rows = $resultSet->fetch_assoc())
                        {
                            $optionColour = strtolower($rows['Colour']);
                            $optionDesc = $rows['Description'];
                            $optionURL = $rows['image'];

                            echo("
                                <div class='sg-box'>
                                    <label for='$optionDesc'> 
                                        <img class='sg-box-image' src='$optionURL$optionColour.jpg' alt='$optionDesc'>
                                    </label>
                                    <label class='sg-swatch-label'>
                                            <input type='radio' class='fabricRadio' name='fabric' onclick='getFabric(this.value)' id='$optionDesc' value='$optionDesc'>
                                            <span class='check-text'>$optionColour</span>                                
                                            <span class='sg-check'></span>
                                    </label>
                                </div>
                            ");
                        
                        }
            
                if($row_cnt == 0){
                    echo "No Fabrics Available In Selected Size"; 
                }

        }
    }
}


}



?>
