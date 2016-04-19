<?php
/*
* emailPasswordReset.php
*
* Email the user a unique link to reset their password
*/

require_once 'class.phpmailer.php';
require_once 'class.smtp.php';

$email = $_POST['email'];

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "smtp.gmail.com";
$mail->SMTPDebug  = 0; // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true; // enable SMTP authentication
$mail->Port       = 25;  // set the SMTP port for the GMAIL server
$mail->Username   = "wooistopics@gmail.com"; // SMTP account username
$mail->Password   = ""; // SMTP account password

$mail->setFrom('wooistopics@gmail.com', 'ISTopics');
$mail->addAddress("{$email}");
$mail->addReplyTo('wooistopics@gmail.com', 'ISTopics');

$mail->isHTML(true);

$mail->Subject = 'Reset Your ISTopics Password';
$mail->Body    = 'Reset your ISTopics password <a href="tmatlak18.wooster.edu">here</a>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    $_SESSION['error'] = 1;
    $_SESSION['error_msg'] = 'Message could not be sent';
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    $_SESSION['message'] = 1;
    $_SESSION['msg'] = 'Message has been sent.';

    echo 'Message has been sent';
}

header("Location: /signin");
exit();

?>