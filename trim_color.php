<?php

include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

    $trim = strtolower($_POST['trim']);

/*---------------------------------------------------------------------------------------------------*/
    //Color Finish Query
    //$optionName = 'rei';

    //$url = "image/accessories/trim/" .$trim ."/" .$optionName;
    //echo $url;

    $colorquery = "SELECT color FROM _trim_color where trim = '$trim';";
    $result = $conn->query($colorquery);
    // echo $colorquery;
    $row_cnt = $result->num_rows;

    if($row_cnt > 0){
    // echo ('<option selected disabled value="Select Your Color">―Select Your Color―</option>');
        while($rows = $result->fetch_assoc()) {
            $optionName = strtolower($rows['color']);

            // echo "<option value='$optionName'>$optionName</option>"; 
            $imageUrl = "image/accessories/trim/" .$trim ."/" .$optionName .".png";
            // echo $imageUrl;
        
            //TO DO FIX THING
            // echo("<div class='sg-box hem-box'>");
            // echo("<label for='$optionName'>");
            // echo("<img class='sg-box-image' src='$imageUrl' alt='$optionName'>");
            // echo("</label>");
            // echo("<label class='sg-swatch-label'>");
            // echo("<input type='radio' class='trimRadio' name='trims' onclick='(this.value)' id='$optionName' value='$optionName'>");
            // echo("<span class='check-text'></span>");         
            // echo("<span class='sg-check'></span>");
            // echo("</label>");
            // echo("</div>");

            echo("
            <div class='sg-box hem-box'>
                <div>
                <label for='$optionName'> 
                    <img class='sg-box-image' src='$imageUrl' alt='$optionName'>
                </label>
                <label class='sg-swatch-label'>
                        <input type='radio' class='trimRadio' name='trim' onclick='getTrim(this.value)' id='$optionName' value='$optionName'>
                        <span class='check-text'>$optionName</span>                                
                        <span class='sg-check'></span>
                </label>
                </div>
            </div>");
        }
    }
    // else if($row_cnt == 1){
    //     echo ('<option disabled value="Select Your Color">―Select Your Color―</option>');
    //     while($rows = $result->fetch_assoc()) {
    //         $optionName = $rows['color'];
    //         echo "<option value='$optionName'>$optionName</option>"; 
    //     }
    // }
    else
    echo "<option value='N/A'>No Colors Available</option>"; 
    
 }

/*---------------------------------------------------------------------------------------------------*/


?>