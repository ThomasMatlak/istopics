<?php
/*
* adminInterface.php
*
* Provide an admin interface such that the database can be edited and reset
*/

if (!isset($_SESSION)) {session_start();}

$page_title = "Database Administration";
include("header.php");

require_once 'displayProfile.php';
require_once 'db_credentials.php';
require_once 'checkSignIn.php';

if (issignedin() == 'admin') {
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

     	<hr>

     	<button class='btn btn-default' type='button' data-toggle='collapse' data-target='#showAllUsers' aria-expanded='false' aria-controls='showAllUsers'>
            Show a List of All Users
     	</button>

     	<div class='collapse' id='showAllUsers'>
            <ul class='list-unstyled'>
EOT;

    $sql = "SELECT id, first_name, last_name, major, year, email, role FROM users";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $user_id    = $row["id"];
   	$first_name = $row["first_name"];
    	$last_name  = $row["last_name"];
    	$major      = $row["major"];
    	$year       = $row["year"];
    	$email      = $row["email"];
    	$role       = $row["role"];

        display_profile($user_id, $first_name. " ". $last_name, true, $major, $year, $email, $role, true);
    }

    echo <<<EOT
            </ul>
        </div>
EOT;

}
else {
     // user is not signed in as an admin, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     header("Location: /project/all");
     exit();
}

include("footer.php");
?>