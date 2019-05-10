<?php
    session_start();

if ($_POST){

    $name = $_POST['name'];
    $purchaseOrder = $_POST['purchaseOrder'];


    $_SESSION['orderName'] = $name;
    $_SESSION['purchaseOrder'] = $purchaseOrder;
    // exit();

}
?>