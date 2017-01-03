<?php
/**
 * Display the project
 */

$page_title = "View Project";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';
require_once 'project.class.php';

$proj_id = $_GET["project_id"];
if (!filter_var($proj_id, FILTER_VALIDATE_INT)) {
   echo "<p>That is not a valid project id.</p>";
}
else {
	$project = new Project();
	$result = $project->get($proj_id, $conn);

    // Display Project
    if ($result !== false) {
        $row = $result;

		$author_name  = addslashes($row["first_name"]. " ". $row["last_name"]);
		$user_id      = $row["user_id"];
		$proj_id      = $row["proj_id"];
		$proj_title   = addslashes($row["title"]);
		$major        = addslashes($row["discipline"]);
		$proposal     = addslashes($row["proposal"]);
		$comments     = addslashes($row["comments"]);
		$keywords     = addslashes($row["keywords"]);
		$last_updated = $row["last_updated"];
        $project_type = $row["project_type"];

		echo "<ul class='list-unstyled'>";

		if (issignedin() != -1) {
            $userid = $_SESSION['sess_user_id'];
            $sql1 = "SELECT userid, projectid FROM user_project_favorites WHERE projectid={$proj_id} AND userid={$userid}";

            $result1 = $conn->query($sql1);

            if ($result1->num_rows > 0) {
                $fav_status = true;
            }
            else {
                $fav_status = false;
            }
        }
		else {
            $fav_status = false;
        }

		display_project($proj_id, $author_name, $user_id, $proj_title, $major, $proposal, $keywords, $comments, $last_updated, true, true, $fav_status, $project_type, $conn);

		echo "</ul>";

    	if (isset($_SESSION["sess_user_role"]) && isset($_SESSION["sess_user_id"])) {
			if (($_SESSION["sess_user_role"] == "admin") || ($_SESSION["sess_user_id"] == $user_id)) {
					echo "<a href='/istopics/project/{$proj_id}/edit' class='btn btn-warning'>Edit Project</a>";
			}
        }

    } else {
        echo "<p>Project Not Found.</p>";
    }

    // Close connection
    $conn->close();
}

include("footer.php");
