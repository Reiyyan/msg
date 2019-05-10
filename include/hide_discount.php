<?php
if ($_POST){

    $hide = $_POST['hide'];
    
    if(empty($hide) ){
        header("Location: ../index.php?error=emptyfields");
        exit();
    }
    else{
        session_start();
        $_SESSION['hide'] = $hide;
        // echo($_SESSION['hide']);
        // header("Location: ../index.php?orderName=".$orderName."&PO=".$purchaseOrder);
        // header("Location: {$_SERVER["HTTP_REFERER"]}");
        // exit();
    }

}
?>