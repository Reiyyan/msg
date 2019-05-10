<?php
/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Include the Composer generated autoload.php file. */
require 'composer/vendor/autoload.php';

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "donotreply@mysunglow.com";
$mail->Password = "sgorderform";
$mail->SetFrom("donotreply@mysunglow.com");
$mail->Subject = "SunGlow - Received Order: " .$orderTag;
$mail->Body = "Thank you for placing your order tagged: '".$orderTag."' via the Sun Glow Online Ordering System.  Your company will receive an official sales order confirmation once our customer service team has reviewed and processed your submission.
<br><br>
If your company does not receive a sales order confirmation within 2 business days, or if you require any alterations to a submitted order, please contact the Sun Glow customer service team at cs@mysunglow.com or 1 (800) 668-1728.
<br><br>
Thank you for your business.
<br><br>
Sun Glow Window Covering Products of Canada Ltd. <br>
50 Hollinger Road Toronto, Ontario, Canada M4B 3G5<br>
p.  416-266-3501 | p.  1-800-668-1728 | f.  416-266-5484 | f.  1-877-245-9943";
$mail->AddAddress($email);

if(!$mail->Send()) {
echo "Mailer Error: " . $mail->ErrorInfo;
// header("Location: ../orders.html?submission=failed");
} else {
echo "Message has been sent";
// header("Location: ../orders.html?submission=success");
}

?>


