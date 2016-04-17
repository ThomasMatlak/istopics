<?php
/*
* forgotPassword.php
*
* Present the user with a form to email them a password reset link
*/

include 'header.php';
?>

<form action='/emailPasswordReset.php' method='POST' class='form'>
    <label for='email'>Enter Your Email</label>
    <input type='email' name='email' id='email' class='form-control' required>
    <button type='submit' class='btn btn-warning'>Send Email to Rest Password</button>
</form>

<?php
include 'footer.php';
?>