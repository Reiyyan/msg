<?php
if ($_POST){
    session_start();

    require 'o_db.php';

    $quantity = $_POST['quantity'];
    $product = $_POST['product'];
    $price = $_POST['price'];
    $code = $_POST['code'];

    $price = $price * $quantity;

    $reid = $_POST['reid'];

    $email = $_SESSION['email'];
    $orderTag = $_SESSION['orderName'];
    $purchaseOrder = $_SESSION['purchaseOrder'];

    // echo($quantity);
    // echo($product);
    // echo($price);
    // echo($reid);
    // echo($orderTag);
    // echo($email);

    $query = "SELECT reid FROM  order_entry WHERE reid = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../addons.php?error=sqlerror");
        exit();
    }
    //If it exists, skip adding it
    else{
        mysqli_stmt_bind_param($stmt, "s", $reid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if($resultCheck == 1){
            // $stmt = mysqli_stmt_init($conn);
            // $query = "DELETE FROM order_entry WHERE `reid` = '$reid'";
            // $myresult = $conn->query($query);
            // echo ("deleting row");
            header("Location: ../addons.php?error=reIDError");
            exit();
        }
    }
        // then insert new row

        $stmt = mysqli_stmt_init($conn);

        $query = "INSERT INTO order_entry (email, reid, orderTag, PO, product, quantity, price, code) VALUES (?,?,?,?,?,?,?,?);";
        if(!mysqli_stmt_prepare($stmt, $query)){
            echo ("ERROR IN STMT");
            //CATCHES MISSING ERRORS HERE
            // header("Location: ../r2.html?error=ERROR REI SQL");
            // exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "sssssiis", $email, $reid, $orderTag, $purchaseOrder, $product, $quantity, $price, $code);
            mysqli_stmt_execute($stmt);
            echo ('Addons Sent');
            // header("Location: ../summary.html?lineAdded=success");
            // exit();
        }

    //Adding to Order Table

    $query = "SELECT orderTag FROM order_tag WHERE orderTag = ?";
    $stmt = mysqli_stmt_init($conn);
    // echo($query);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../roller.html?error=sqlerror");
        exit();
    }
    //If it exists, error
    else{
        mysqli_stmt_bind_param($stmt, "s", $orderTag);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        
        if($resultCheck != 0){
            // header("Location: ../orders.html?name=exists");
            echo($query);
            echo("Order Exists, not making new");
        }
        else{
            // then insert new row
            $stmt = mysqli_stmt_init($conn);

            // $query = "INSERT INTO order_tag (orderTag, `date`, `email`) VALUES ('$orderTag', '$sg_date', '$email');";
            // $result = $conn->query($query);

            $query = "INSERT INTO order_tag (orderTag, `date`, `email`, `PO`) VALUES (?,?,?,?);";
            if(!mysqli_stmt_prepare($stmt, $query)){
                //CATCHES MISSING ERRORS HERE
                // header("Location: ../r2.html?error=ERROR REI SQL");
                // exit();
                echo("Error in Order Query");
            }
            else{
                $sg_date = date("Y-m-d");
                mysqli_stmt_bind_param($stmt, "sss", $orderTag, $sg_date, $email, $purchaseOrder);
                mysqli_stmt_execute($stmt);
                echo("OTHER SUCCESS");
                // echo ('Success Rei');
                // header("Location: ../r2.html?lineAdded=success");
                // exit();
            }
        }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // header("Location: ../summary.html?lineAdded=success");
    }
}
else{
    echo ('No Post');
    header("Location: ../summary.html?result=FailedPost");
    exit();
}

    // if( empty($orderName) ){
    //     header("Location: ../r2.html?error=emptyfields");
    //     exit();
    // }
    // else{
    //     session_start();
    //     $_SESSION['orderName'] = $orderName;
    //     header("Location: ../roller.html?orderName=".$orderName);
    //     exit();
    // }

    // mysqli_stmt_close($stmt);
    // mysqli_close($conn);
    // }
?>