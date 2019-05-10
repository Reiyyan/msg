<?php
if(isset($_POST["change_pw"])){

    $pwd = $_POST['password'];
    $pwd_r = $_POST['password_r'];
    $eMail = $_POST['email'];

    if(empty($pwd) || empty($pwd_r)){
        header("Location: ../signup.php?newpwd=empty");
        exit();
    } else if($pwd != $pwd_r){
        header("Location: ../signup.php?newpwd=pwdnotsame");
        exit();
    }

    require 's_db.php';

    $sql = "SELECT * FROM user WHERE email = ?";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Cannot find User in Database with selected email!";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $eMail);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)){
            echo "There was an error finding the email!";
            exit();
        }
        else{
            
            $sql = "UPDATE user SET password = ? where email = ?";

            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "Cannot update User in Database with selected email!";
                exit();
            }
            else{
                $passwordHash = password_hash($pwd, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $eMail);
                mysqli_stmt_execute($stmt);

                header("Location: ../profile.php?newpwd=passwordUpdated");
                }
            }
        }
}
else{
    header("Location: ../home.html");
}



?>