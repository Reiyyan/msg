<?php
    // echo('BEFORE POST');

if ($_POST){

    require '../include/o_db.php';

    $reid = $_POST['reid'];

    $query = "SELECT reid FROM order_entry WHERE reid = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../summary.html?error=sqlerror");
        exit();
    }
    //If it exists, delete it
    else{
        mysqli_stmt_bind_param($stmt, "s", $reid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if($resultCheck == 1){
            $query = "DELETE FROM order_entry WHERE `reid` = '$reid'";
            $myresult = $conn->query($query);
        }
        header("Location: ../summary.html");
        exit();
    }

}

?>