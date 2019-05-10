<?php 

    include 'config.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    if ($_POST){
        //Assigning the Control Type Posted
        $hem = $_POST['hem'];
    
        if($hem == 'Front Wrapped Accubar'){
            $hem = 'Accubar';
        }
        echo($hem);

        $result = $conn->query("SELECT end, color_hex FROM _hem_cap where hem = '$hem';");

        $row_cnt = $result->num_rows;

        if($row_cnt == 1){
            echo ("<option disabled selected value='N/A'>―Select Your Finish―</option>");
        }
        else{
            echo ("<option disabled selected value='N/A'>―Select Your Finish―</option>");
        }
        while($rows = $result->fetch_assoc())
        {
            $optionName = $rows['end'];
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
?>
