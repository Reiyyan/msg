<?php
if (isset($_POST['orderNameSave'])){
    require 'o_db.php';

    $orderName = $_POST['orderName'];
    $purchaseOrder = $_POST['purchaseOrder'];
    
    if( empty($orderName) ){
        header("Location: ../index.php?error=emptyfields");
        exit();
    }
    else{
        session_start();
        $_SESSION['orderName'] = $orderName;
        $_SESSION['purchaseOrder'] = $purchaseOrder;

        // header("Location: ../index.php?orderName=".$orderName."&PO=".$purchaseOrder);
        $page = (basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)));
        if($page == 'orders.html'){
            header("Location: ../index.php?orderName=".$orderName."&PO=".$purchaseOrder);
        }
        else{
            header("Location: {$_SERVER["HTTP_REFERER"]}");
        }
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    }
?>