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
        $system = $_POST['system'];

        if($system == 'fascia'){
            $result = $conn->query("SELECT color FROM _fascia_cover;");

            $row_cnt = $result->num_rows;

            if($row_cnt == 1){
                echo ("<option disabled value='Select Your Finish'>―Select Your Finish―</option>");
            }
            else{
                echo ("<option disabled selected value='Select Your Finish'>―Select Your Finish―</option>");
            }

            while($rows = $result->fetch_assoc())
            {
                $optionName = $rows['color'];
                echo "<option value='$optionName'>$optionName</option>"; 
            }
        }

        else if($system == 'open'){
            $result = $conn->query("SELECT color FROM _open_cover;");

            $row_cnt = $result->num_rows;

            if($row_cnt == 1){
                echo ("<option disabled value='Select Your Finish'>―Select Your Finish―</option>");
            }
            else{
                echo ("<option disabled selected value='Select Your Finish'>―Select Your Finish―</option>");
            }

            while($rows = $result->fetch_assoc())
            {
                $optionName = $rows['color'];
                echo "<option value='$optionName'>$optionName</option>"; 
            }
        }

        else{
            echo ("<option disabled selected value='NA'>―No Finish Available―</option>");
        }
    }
?>
