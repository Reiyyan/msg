<?php
if(isset($_POST["reset_submit"])){

    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $pwd = $_POST['password'];
    $pwd_r = $_POST['password_r'];

    if(empty($pwd) || empty($pwd_r)){
        header("Location: ../signup.php?newpwd=empty");
        exit();
    } else if($pwd != $pwd_r){
        header("Location: ../signup.php?newpwd=pwdnotsame");
        exit();
    }

    $currentDate = date("U");

    require 's_db.php';

    $sql = "SELECT * FROM pwd_reset WHERE selector = ? AND expiry >= $currentDate";
     
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error finding row with your selection.";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)){
            echo "Selection Unavailable, Please resubmit your reset request.";
            exit();
        }
        else{

            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['token']);

            if($tokenCheck === false){
                echo "Check Failed: Please resubmit your reset request.";
                exit();
            } 
            else if($tokenCheck === true){
                
                $tokenEmail = $row['email'];

                $sql = "SELECT * FROM user WHERE email = ?";

                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Cannot Select User in Database with selected email!";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
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
                            echo "Cannot Update User in Database with selected email!";
                            exit();
                        }
                        else{
                            $passwordHash = password_hash($pwd, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            //DELETE TOKEN
                                $sql = "DELETE FROM pwd_reset WHERE email = ?";

                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    echo "No Token found in Database with selected email!";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../signup.php?newpwd=passwordUpdated");
                                }
                        }
                    }
                    
                }
            }

        }
    }

}
else{
    header("Location: ../home.html");
}



?>