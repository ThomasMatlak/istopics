<?php
/*
* emailPasswordReset.php
*
* Email the user a unique link to reset their password
*/

$email = $_POST['email'];

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "smtp.gmail.com";
$mail->SMTPDebug  = 0; // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true; // enable SMTP authentication
$mail->Port       = 25;  // set the SMTP port for the GMAIL server
$mail->Username   = "wooistopics"; // SMTP account username
$mail->Password   = ""; // SMTP account password

header("Location: /signin");
exit();

?>