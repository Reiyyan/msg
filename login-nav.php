

<form id="login-nav" action="include/i_login.php" method="post">
    <input type="text" name="mailuid" placeholder="User">
    <input type="password" name="password" placeholder="Password">
    <span class="sg-dropdown">
    <button class="sg-dbtn" type="submit" name="submit_login"> Log In </button>
    </span>
</form>


    

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

