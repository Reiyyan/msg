<?php
if (isset($_POST['submit_login'])){


    require 'i_db.php';

    $username = $_POST['mailuid'];
    $password = $_POST['password'];

    if( empty($username) || empty($password) ){
        header("Location: ../login.php?error=emptyfields&uid=".$username);
        exit();
    }
    else{
        $query = "SELECT * FROM user WHERE name = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $query)){
            header("Location: ../login.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['password']);
                if($pwdCheck == false){
                    header("Location: ../login.php?error=wrongpwd");
                    exit();
                }
                else if($pwdCheck == true){
                    session_start();
                    $_SESSION['test'] = $row;
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id'] = $row['iduser'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['ship'] = $row['ship'];
                    $_SESSION['discount'] = $row['discount'];
                    $_SESSION['hide'] = 'false';

                    header("Location: ../index.php?login=success");
                    exit();

                }
                else{
                    header("Location: ../login.php?error=nouser");
                    exit();
                }
            }
            else{
                header("Location: ../login.php?error=nouser");
                exit();
            }
        }
    }

}
else{
    header("Location: ../login.php");
    exit();
}
?>