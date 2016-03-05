<?php
/*
* logout.php
*
* Clear session variables and destroy the session to sign out the user
*/

session_start();

//Clean up the session
session_unset();

session_destroy();

//Redirect to home page
header("Location: showAllProjects.php");
exit();

?>