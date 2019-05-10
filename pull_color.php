<?php

include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

    $pull=  $_POST['pull'];

/*---------------------------------------------------------------------------------------------------*/
//Color Finish Query

    $colorquery = "SELECT color FROM _pull_color where pull = '$pull';";
    $result = $conn->query($colorquery);
    
    $row_cnt = $result->num_rows;

    if($row_cnt > 0){
    // echo ('<option selected disabled value="Select Your Color">―Select Your Color―</option>');
        while($rows = $result->fetch_assoc()) {
            $optionName = $rows['color'];
            $imageUrl = "image/accessories/pull/" .$pull ."/" .$optionName .".png";
            // echo "<option value='$optionName'>$optionName</option>";
            
            echo("<div class='sg-box hem-box'>
                <div>
                <label for='$optionName'> 
                    <img class='sg-box-image' src='$imageUrl' alt='$optionName'>
                </label>
                <label class='sg-swatch-label'>
                        <input type='radio' class='pullRadio' name='pull' onclick='getPull(this.value)' id='$optionName' value='$optionName'>
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