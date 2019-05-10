<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    
<link rel="stylesheet" href="normalize.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">

<head>
<title>Login Page</title>
</head>

<body>

<?php
include 'sg-header.php';
?>
<?php 
    include 'include/links.php';
?>


<br>
<br>
<br>
<br>
<br>
<div class="wrapper">
<section class="heading">
            <h1 id="title">Login Page</h1>
</section>

<div class="header-login">

<form action="include/i_login.php" method="post">
    <input type="text" name="mailuid" placeholder="eMail/User Name">
    <br>

    <input type="password" name="password" placeholder="Password">
    <br>
    <br>
    <button class="sg-login" style="margin: auto;"  type="submit" name="submit_login"> Login </button>
</form>

<br>

<form action="include/i_logout.php" method="post">

    <button class='sg-logout' style="margin: auto;" type="submit" name="submit_logout"> Logout </button>
    
</form>

<?php
if(isset($_GET['error'])){
    if($_GET['error'] == "emptyfields"){
        echo ('<p>Please Fill In All Fields!</p>');
    }
    else if($_GET['error'] == "sqlerror"){
        echo ('<p>Database Error!</p>');
    }
    else if($_GET['error'] == "nouser"){
        echo ('<p>User Doesn\'t exist!</p>');
    }
    else if($_GET['error'] == "wrongpwd"){
        echo ('<p>Please Enter a Valid Password!</p>');
    }
}
else if (isset($_GET['login'])){
    if($_GET['login'] == 'success'){
    echo ('<p>Logging in!</p>');
    }
}
?>

<?php
    if(isset($_SESSION['discount'])){

        // echo ("<p> You are Logged in </p>");
        // echo $_SESSION['discount'];
    }

    else{

        // echo ("<p> You are Logged out </p>");
        
    }

?>

</div>
</div>
</body>

</html>