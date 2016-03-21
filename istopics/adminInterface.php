<?php
/*
* adminInterface.php
*
* Provide an admin interface such that the database can be edited and reset
*/

session_start();

$page_title = "Database Administration";
include("header.php");

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"]) && ($_SESSION["sess_user_role"] == "admin")) {
// user is signed in as an admin

echo <<<EOT
     <form action='' method='POST'><button class='btn btn-error'>Delete All Projects</button></form>
     <form action='' method='POST'><button class='btn btn-error'>Delete All Users</button></form>
EOT;
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

include("footer.php");
?>