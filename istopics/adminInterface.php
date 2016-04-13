<?php
/*
* adminInterface.php
*
* Provide an admin interface such that the database can be edited and reset
*/

if (!isset($_SESSION)) {session_start();}

$page_title = "Database Administration";
include("header.php");

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"]) && ($_SESSION["sess_user_role"] == "admin")) {
// user is signed in as an admin

echo <<<EOT
     <a href='/dbToCSV.php' class='btn btn-primary'>Download Projects as CSV</a>

     <hr>

     <script src='/js/resetDatabaseWarning.js'></script>
     <button onclick='resetWarning();' class='btn btn-danger'>Reset Database</button>
     <span class='help-block'>Resetting the database will delete all projects, connections between projects and users, and non-admin users.</span>

     <hr>

     <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#promoteUser" aria-expanded="false" aria-controls="promoteUser">
         Promote a User to Admin
     </button>
     <div class="collapse" id="promoteUser">
         <form action='/promoteUser.php' method='POST' class='form-inline'>
	     <div class='form-group'>
	         <label for='email'>Email:</label>
		 <input type='email' name='email' id='email' class='form-control'>
	     </div>
	     <button type='submit' class='btn btn-primary'>Promote User to Admin</button>
	 </form>
     </div>
EOT;
}
else {
     // user is not signed in as an admin, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: /project/all");
     exit();
}

include("footer.php");
?>