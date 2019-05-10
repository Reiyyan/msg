<?php


include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_POST){

    $clutch=  $_POST['clutch_system'];

/*---------------------------------------------------------------------------------------------------*/
//Color Finish Query

    $colorquery = "SELECT colour FROM _clutch_color where clutch = '$clutch';";
    $result = $conn->query($colorquery);
    
    $row_cnt = $result->num_rows;

    if($row_cnt > 0){
    echo ('<option disabled value="N/A">―Select Your Colour―</option>');
    while($rows = $result->fetch_assoc()) {
        $optionName = $rows['colour'];
        echo "<option value='$optionName'>$optionName</option>"; 
    }
    }
    else
    echo "<option value='N/A'>No Colours Available</option>"; 
    
 }

/*---------------------------------------------------------------------------------------------------*/

?>