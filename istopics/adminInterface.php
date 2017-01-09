<?php
/**
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
?>
<h4>Download Projects as CSV</h4>
<form action="/istopics/dbToCSV.php" method="post">
    <div class="form-group">
        <label for="discipline" class="control-label">Major/Discipline</label>
        <?php include 'majors.html'; ?>
    </div>
    <div class="form-group">
        <label for="project_keywords" class="control-label">Keywords</label>
        <input type="text" name="project_keywords" id="project_keywords" class="form-control">
    </div>
    <div class="form-group">
        <label for="project_type">Project Type</label>
        <label class="checkbox-inline">
            <input type="checkbox" name="project_type[]" value="senior"> Senior I.S.
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="project_type[]" value="junior"> Junior I.S.
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="project_type[]" value="other"> Other Research Projects
        </label>
    </div>
	<button type="submit" class="btn btn-primary">Download Projects as CSV</button>
</form>

<hr>

<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#promoteUser" aria-expanded="false" aria-controls="promoteUser">
	Promote a User to Admin
</button>
<div class="collapse" id="promoteUser">
	<form action='/istopics/promoteUser.php' method='POST' class='form-inline'>
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
	<form class='form-inline'><div class='form-group'><input type='text' name='search' id='search' placeholder='Filter Users' class='form-control'></div><span class='help-block'>Filter Users by Name, Role, Major, Graduation Year, and Email</span></form>

	<ul id="users_list" class='list-unstyled'>
<?php
    $sql = "SELECT id, first_name, last_name, major, year, email, role FROM users";
    $result = $conn->query($sql);

	$users_json = '\'{"users":[';
    $first = true; // add a comma before all entries except the first one

    while ($row = $result->fetch_assoc()) {
        $user_id    = $row["id"];
   		$first_name = $row["first_name"];
    	$last_name  = $row["last_name"];
    	$major      = $row["major"];
    	$year       = $row["year"];
    	$email      = $row["email"];
    	$role       = $row["role"];

        display_profile($user_id, $first_name. " ". $last_name, true, $major, $year, $email, $role, true);

		($first === false) ? $users_json .= ',' : $first = false;

		$users_json .= '{';
		$users_json .= "\"id\":\"{$user_id}\",\"first_name\":\"{$first_name}\",\"last_name\":\"{$last_name}\",\"role\":\"{$role}\",\"email\":\"{$email}\",\"year\":\"{$year}\",\"major\":\"{$major}\"";
		$users_json .= '}';
    }

	$users_json .= "]}'";
?>
	</ul>
</div>

<script>
	var u = JSON.parse(<?php echo $users_json; ?>);
</script>

<script src='/istopics/js/userTemplate.js'></script>
<script src='/istopics/js/filterUsers.js'></script>

<hr>

<script src='/istopics/js/resetDatabaseWarning.js'></script>
<button onclick='resetWarning();' class='btn btn-danger'>Reset Database</button>
<span class='help-block'>Resetting the database will delete all projects, connections between projects and users, and non-admin users.</span>
<?php
}
else {
     // user is not signed in as an admin, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";

     header("Location: /istopics/project/all");
     exit();
}

include("footer.php");
