<?php
/*
* adminInterface.php
*
* Provide an admin interface such that the database can be edited and reset
*/

session_start();

$page_title = "Database Administration";
include("header.php");

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) ){// && isset($_SESSION["sess_user_role"]) && ($_SESSION["sess_user_role"] == "admin")) {
// user is signed in as an admin

echo <<<EOT
     <script src='js/resetDatabaseWarning.js'></script>
     <button onclick='resetWarning();' class='btn btn-danger'>Reset Database</button>
EOT;
}
else {
     // user is not signed in as an admin, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

include("footer.php");
?>