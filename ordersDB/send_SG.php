<?php

    session_start();
    $email = $_SESSION['email'];

if ($_POST){

    require '../include/o_db.php';

    if(isset($_POST['orderTag'])){
        $orderTag = $_POST['orderTag'];
    }
    else{
        $orderTag = $_SESSION['orderName'];
    }

    $query = "SELECT orderTag FROM order_tag WHERE orderTag = ?";
    $stmt = mysqli_stmt_init($conn);
    echo($query);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../roller.html?error=sqlerror");
        exit();
    }
    //If it cannot prepare exists, error
    else{
        //attach params and prepare
        mysqli_stmt_bind_param($stmt, "s", $orderTag);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        
        if($resultCheck == 1){
            // header("Location: ../orders.html?name=exists");
            echo($query);
            echo("Order Exists, Perfect, Let's Submit it");
            $stmt = mysqli_stmt_init($conn);

            $query = "UPDATE order_tag SET `submit` = (?) WHERE `orderTag` = (?);";
            if(!mysqli_stmt_prepare($stmt, $query)){
                //CATCHES MISSING ERRORS HERE
                // header("Location: ../r2.html?error=ERROR REI SQL");
                // exit();
                echo("Error in Order Query");
            }
            else{
                // $sg_date = date("Y-m-d");
                $x = true;
                mysqli_stmt_bind_param($stmt, "is", $x, $orderTag);
                mysqli_stmt_execute($stmt);
                echo("ORDER SUBMITTED");
                include '..\mail.php';
                // echo ('Success Rei');
                // header("Location: ../r2.html?lineAdded=success");
                // exit();
            }
        }
        else{
            echo("Order Doesn't Exist? Cannot Submit it");
        }
    }
}
else{
    echo('No Postage');
}

?>