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
            <h1 id="title">Profile</h1>
</section>

<div class="header-login">

<!-- <form action="include/i_logout.php" method="post">
    <button type="submit" name="submit_logout"> Logout </button>
</form> -->

<?php
    if(!isset($_SESSION['discount'])){
        header("Location: login.php");
    }
    if(isset($_SESSION['discount'])){
        // echo ("<p> You are Logged in </p>");

        echo ('User ID: ');
        echo $_SESSION['id'];
        echo "<br>";
        echo "<br>";
 
        echo ('User Name: ');        
        echo $_SESSION['name'];
        echo "<br>";
        echo "<br>";

        echo ('eMail: ');
        echo $_SESSION['email'];
        echo "<br>";
        echo "<br>";

        echo ('Discount: ');
        $discount_a = 50;
        $discount_b = $_SESSION['discount']*100/$discount_a-100;

        echo ($discount_a .' / ' .$discount_b);
        echo "<br>";
        echo "<br>";

        echo ('Role: ');
        echo $_SESSION['role'];
        echo "<br>";
        echo "<br>";

        echo ('Shipping Method: ');
        echo $_SESSION['ship'];

        echo "<br>";
        echo "<br>";


        echo('Hide Discounted Prices? ');
        if($_SESSION['hide'] == 'true'){
            echo('<input type="checkbox" id="scales" onclick="hideDiscount(this.checked);" checked>');
        }
        else{
            echo('<input type="checkbox" id="scales" onclick="hideDiscount(this.checked);">');
        }
        echo "<br>";


        echo('<br>
        <p> Change your Password </p>
        <form action="include/i_change_pw.php" method="POST">
            <input type="hidden" name="email" value="' .$_SESSION['email'] .'" ><br>
            <input type="password" name="password" placeholder="Enter a new Password"> <br>
            <input type="password" name="password_r" placeholder="Repeat your Password"> <br><br>
            <button type="submit" name="change_pw">Change Password</button><br>
        </form>

        ');
        echo "<br>";
        echo "<br>";
        echo "<br>";

    }
    else{
        echo ("<p> You are Logged out </p>");
    }

?>

</div>

</div>

<div id='result'></div>

<!-- Footer -->
<?php
    include 'sg-footer.php';
?>

</body>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="reiFunctions.js"></script>

</html>