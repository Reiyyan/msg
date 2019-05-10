<?php

require 'include/o_db.php';

if ($_POST){

    $orderName = $_POST['orderName'];

    $query = "SELECT orderTag FROM order_tag WHERE orderTag = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../orders.html?error=sqlerror");
        exit();
    }

    //If it exists, delete it
    else{
        mysqli_stmt_bind_param($stmt, "s", $orderName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if($resultCheck == 1){
            // $stmt = mysqli_stmt_init($conn);
            $query = "DELETE FROM order_tag WHERE `orderTag` = '$orderName'";
            $myresult = $conn->query($query);
            // echo ("deleting row");
        }
    }
}
?>