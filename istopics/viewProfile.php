<?php
/**
 * View a user profile
 */

if (!isset($_SESSION)) {session_start();}

$page_title = "View Profile";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';
require_once 'displayProfile.php';
require_once 'userprofile.class.php';

if (isset($_GET["user_id"]) && $_GET["user_id"] != '') {
   $user_id = $_GET["user_id"];
}
elseif (isset($_SESSION["sess_user_id"])) {
   $user_id = $_SESSION["sess_user_id"];
}

if (!filter_var($user_id, FILTER_VALIDATE_INT)) {
   echo "<p>That is not a valid user id.</p>";
}
else {
?>
<script src='/js/ellipsify.js'></script>
<script src='/js/expand_contract_pk.js'></script>
<?php
	$user_profile = new UserProfile();
	$result = $user_profile->get($user_id, $conn);
	if ($result !== false) {
		$row = $result;

		$user_id    = $row["id"];
		$first_name = addslashes($row["first_name"]);
		$last_name  = addslashes($row["last_name"]);
		$major      = addslashes($row["major"]);
		$year       = $row["year"];
		$email      = $row["email"];
		$role       = $row["role"];

		echo "<h3>{$first_name} {$last_name}</h3>";

		echo "<ul class='list-unstyled'>";

		display_profile($user_id, $first_name. " ". $last_name, false, $major, $year, $email, $role, false);

		echo "</ul>";

		$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.last_updated, projects.keywords FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE users.id=? ORDER BY title";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $user_id);
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();

		// Display user's projects
		if ($result->num_rows > 0) {
?>
	<hr>
<h4><?php echo $first_name; ?>'s Projects</h4>

<ul class='list-unstyled'>
<?php
			while($row = $result->fetch_assoc()) {
				$proj_id         = $row["proj_id"];
				$proj_title      = addslashes($row["title"]);
				$proj_major      = addslashes($row["discipline"]);
				$proj_proposal   = addslashes($row["proposal"]);
				$proj_keywords   = addslashes($row["keywords"]);
				$last_updated    = $row["last_updated"];

				display_project($proj_id, "", "", $proj_title, $proj_major, $proj_proposal, $proj_keywords, "", $last_updated, false, false, $conn);
			}

			$max_proj_id = $conn->query("SELECT id FROM projects ORDER BY id DESC")->fetch_assoc()['id'];
?>
	</ul>
<input type='hidden' value='{$max_proj_id}' id='max_proj_id'>
<?php
        }
    }
    else {
        echo "<p>User not found.</p>";
    }

    // Close connection
    $conn->close();
}

include("footer.php");
