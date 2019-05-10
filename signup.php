<!DOCTYPE html>
<html>
<head>
<title>Sign Up Page</title>
</head>

<body>

<?php 
    include 'include/links.php';
?>

<h1>Sign Up Page</h1>

<?php
if(isset($_GET['error'])){
    if($_GET['error'] == "emptyfields"){
        echo ('<p>Please Fill In All Fields!</p>');
    }
    else if($_GET['error'] == "invalidemailuid"){
        echo ('<p>Please Enter a Valid User Name and eMail!</p>');
    }
    else if($_GET['error'] == "invalidemail"){
        echo ('<p>Please Enter a Valid eMail!</p>');
    }
    else if($_GET['error'] == "invaliduid"){
        echo ('<p>Please Enter a Valid User Name!</p>');
    }
    else if($_GET['error'] == "passwordcheck"){
        echo ('<p>Please Enter a Valid Password!</p>');
    }
    else if($_GET['error'] == "userTaken"){
        echo ('<p>User Name is already taken!</p>');
    }
    else if($_GET['error'] == "invalidroll"){
        echo ('<p>Please select a Valid Roll!</p>');
    }
    else if($_GET['error'] == "invalidship"){
        echo ('<p>Please select a Valid Shipping Method!</p>');
    }
}
else if (isset($_GET['signup'])){
    if($_GET['signup'] == 'success'){
    echo ('<p>New User created!</p>');
    }
}
?>

<form action="include/i_signup.php" method="POST">
    <input type="text" name="uid" placeholder="User Name">
    <input type="text" name="email" placeholder="eMail">
    <input type="number" name="discount_a" placeholder="Discount" value="50">
    <input type="number" name="discount_b" placeholder="Discount">
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="password_repeat" placeholder="Repeat Your Password">
    <select name="role"> 
        <option disabled selected value="Role">Role</option>
        <option value="Manager">Manager</option>
        <option value="Rep">Rep</option>
    </select>
    <select name="ship"> 
        <option disabled selected value="Shipping">Shipping</option>
        <option value="Collect">Collect</option>
        <option value="Pick Up">Pick Up</option>
        <option value="Prepaid">Prepaid</option>
        <option value="Prepaid & Charged">Prepaid & Charged</option>
    </select>

    <button type="submit" name="submit_signup"> Sign Up </button>
</form>


        <?php
        if(isset($_GET['newpwd'])){
            if($_GET['newpwd'] == "passwordUpdated"){
                echo ('<p>Password has been updated!</p>');
            }
        }
        ?>

    <a href=reset_request.php>Forgot Your Password?</a>

</body>

</html>