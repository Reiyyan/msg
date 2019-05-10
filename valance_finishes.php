<?php


include 'config.php';

$tubesIndex;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

    $valance_type =  $_POST['valance_type'];

/*---------------------------------------------------------------------------------------------------*/
//Valance Finish Query

    $vtypesquery = "SELECT valance_finishes, color_hex FROM _valance_type where valance_type = '$valance_type';";
    $vtyperesult = $conn->query($vtypesquery);
    
    echo ('<option disabled selected value="N/A">―Select Your Finish―</option>');
    while($rows = $vtyperesult->fetch_assoc()) {
        $optionName = $rows['valance_finishes'];
        $colorHex = $rows['color_hex'];

        if($optionName == 'Black'){
            echo "<option disabled value='' style='background: $colorHex;'></option>"; 
            echo "<option value='$optionName' style='background: $colorHex; color: white;'>$optionName</option>";
            echo "<option disabled value='' style='background: $colorHex;'></option>";               
        }
        else{
            echo "<option disabled value='' style='background: $colorHex;'></option>"; 
            echo "<option value='$optionName' style='background: $colorHex;'>$optionName</option>"; 
            echo "<option disabled value='' style='background: $colorHex;'></option>"; 
        }
    }
 }

/*---------------------------------------------------------------------------------------------------*/

?>