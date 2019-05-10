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
            echo $hem;
        $hTypeResult = $conn->query("SELECT hem_finish, color_hex FROM _hem_type where hem_type = '$hem';");

        
        $row_cnt = $hTypeResult->num_rows;

        if($row_cnt == 1){
            echo ("<option disabled selected value='N/A'>―Select Your Finish―</option>");
        }

        else if( ($hem == 'Decorative Hem w/ Gimp') || ($hem == 'Decorative Hem w/ Gimp & 1" Loop') || ($hem == 'Decorative Hem w/ Gimp & 2" Chainette') ){
            echo ("<option disabled selected value='N/A'>―Select Your Style―</option>");
        }

        else{
            echo ("<option disabled selected value='N/A'>―Select Your Finish―</option>");
        }

        while($rows = $hTypeResult->fetch_assoc())
        {
        $optionName = $rows['hem_finish'];
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
