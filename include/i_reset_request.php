<?php

if(isset($_POST['reset_request'])){

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = 'https://ordertest.sunglow-wholesale.com/create_new_password.php?selector=' .$selector . '&validator=' .bin2hex($token);

    $expiry = date("U") + 1800;

    require 's_db.php';


    $eMail = $_POST['email'];

    $sql = "DELETE FROM pwd_reset where email = ?";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error Connecting to Database Rei!";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $eMail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwd_reset (email, selector, token, expiry) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error Connecting to Database Rei!";
        exit();    
    }
    else{
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $eMail, $selector, $hashedToken, $expiry);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $to = $eMail;
    $subject = "MySunGlow Password Reset";

    $message = '<p>We received a password reset request. The link to reset your password can be found below. If you did not make this request, you can ignore this eMail.</p> 
                <p> Password reset link : <br> <a href ="' .$url . '">' .$url .'</a></p>';

    
    $headers = "From: MySunGlowDealers <no-reply@mysunglow.com>\r\n";
    $headers .= "Reply-To: MySunGlowDealers <no-reply@mysunglow.com>\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header('Location: ../reset_request.php?reset=success');
}
else{
    header("Location: ../home.html");
}

?>