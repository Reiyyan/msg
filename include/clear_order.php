<?php
if ($_POST){

    session_start();
    // $_SESSION['orderName'] = $orderName;
    // $_SESSION['purchaseOrder'] = $purchaseOrder;
    if(isset($_SESSION['orderName'])){
    
    unset($_SESSION['orderName']);
    unset($_SESSION['purchaseOrder']);

    // header("Location: ../index.php?cleared=true");
    }
}
?>