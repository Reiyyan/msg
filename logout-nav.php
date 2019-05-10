<form action="include/i_logout.php" method="post">
    <button type="submit" name="submit_logout"> Logout </button>
<?php
    if(isset($_SESSION['discount'])){
        echo ("<p> You are Logged in </p>");
        echo $_SESSION['discount'];
    }
    else{
        echo ("<p> You are Logged out </p>");
    }

?>