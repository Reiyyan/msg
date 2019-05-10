<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
</head>

<body>

<?php 
    include 'include/links.php';
?>

<h1>New Password</h1>


<?php
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];

    if(empty($selector) || empty($validator)){
        echo "Could not validate your request!";
    }
    else{
        if(ctype_xdigit($selector) == true && ctype_xdigit($validator) == true){

            echo('<form action="include/i_reset_pw.php" method="POST">
                    <input type="hidden" name="selector" value="' .$selector .'" >
                    <input type="hidden" name="validator" value="' .$validator .'" >
                    <input type="password" name="password" placeholder="Enter a new Password"> 
                    <input type="password" name="password_r" placeholder="Repeat your Password"> 
                <button type="submit" name="reset_submit">Reset my password</button>
                </form>
            ');
        }
    }

?>

    <a href=reset_request.php>Forgot Your Password?</a>
</body>

</html>