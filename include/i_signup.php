<?php

if (isset($_POST['submit_signup'])){

    require 's_db.php';

    $username = $_POST['uid'];
    $email = $_POST['email'];
    $discount_a = $_POST['discount_a'];
    $discount_b = $_POST['discount_b'];
    $password = $_POST['password'];
    $password_r = $_POST['password_repeat'];
    $role = $_POST['role'];
    $ship = $_POST['ship'];

    $discount;
    $discount = $discount_a*(100+$discount_b)/100;

    if( empty($username) || empty($email) || empty($discount) || empty($password) || empty($password_r) || empty($role) || empty($ship) ){
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&email=".$email."&discount=".$discount);
        exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invalidemailuid=".$username);
        exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidemail&uid=".$username."&discount=".$discount);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invaliduid&email=".$email."&discount=".$discount);
        exit();
    }
    else if($password !== $password_r){
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&email=".$email."&discount=".$discount);
        exit();
    }
    else if($role == 'role'){
        header("Location: ../signup.php?error=invalidroll");
        exit();
    }
    else if($ship == 'Shipping'){
        header("Location: ../signup.php?error=invalidship");
        exit();
    }
    
    else{

        $query = "SELECT name FROM user WHERE name = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){

            header("Location: ../signup.php?error=sqlerror");
            exit();

        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if($resultCheck > 0){
                header("Location: ../signup.php?error=userTaken&email=".$email."&discount=".$discount);
                exit();
            }
            else{
                $query = "INSERT INTO user (name, email, password, discount, role, ship) VALUES (?, ?, ?, ?, ?, ?)";
                if(!mysqli_stmt_prepare($stmt, $query)){
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                else{
                    $hashPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sssdss", $username, $email, $hashPwd, $discount, $role, $ship);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }


    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else{
    header("Location: ../signup.php");
    exit();
}

?>