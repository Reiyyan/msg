<?php
$to = "ecomm@mysunglow.com";
$subject = "My Test";
$txt = "Hello world!";
$headers = "From: do-not-reply@mysunglow.com";

mail($to,$subject,$txt,$headers);
?>