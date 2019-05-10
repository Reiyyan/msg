<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
</head>

<body>

<?php 
    include 'include/links.php';
?>

<h1>Password Reset</h1>

<p>An eMail will be sent to you with instructions on how to reset your password.</p>

<form action="include/i_reset_request.php" method="POST">
    <input type="text" name="email" placeholder="eMail Address">
    <button type="submit" name="reset_request"> Submit </button>
</form>

<?php
if(isset($_GET['reset'])){
    if($_GET['reset'] == "success"){
        echo ('<p>Please Check Your eMail!</p>');
    }
}
?>

    <a href=reset_request.php>Forgot Your Password?</a>
</body>

</html>