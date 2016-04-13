<?php
/*
* viewProject.php
* 
* Display the project 
*/

$page_title = "View Project";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';

$proj_id = $_GET["project_id"];
if (!filter_var($proj_id, FILTER_VALIDATE_INT)) {
   echo "<p>That is not a valid project id.</p>";
}
else {
$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.comments, projects.keywords, projects.last_updated, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE projects.id={$proj_id}";
$result = $conn->query($sql);

// Display Project
if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();

   $author_name = $row["first_name"]. " ". $row["last_name"];
   $user_id     = $row["user_id"];
   $proj_id     = $row["proj_id"];
   $proj_title  = $row["title"];
   $major       = $row["discipline"];
   $proposal    = $row["proposal"];
   $comments    = $row["comments"];
   $keywords    = $row["keywords"];
   $last_updated = $row["last_updated"];

   echo "<ul class='list-unstyled'>";

   display_project($proj_id, $author_name, $user_id, $proj_title, $major, $proposal, $keywords, $comments, $last_updated, true, true);

   echo "</ul>";

    if (isset($_SESSION["sess_user_role"]) && isset($_SESSION["sess_user_id"]) && ($_SESSION["sess_user_role"] == "admin") || ($_SESSION["sess_user_id"] == $user_id)) {
        echo "<form action='/project/edit' method='GET'>\n<input type='hidden' name='project_id' value='{$proj_id}'><button type='submit' class='btn btn-warning'>Edit Project</button></form>";
    }

} else {
    echo "<p>Project Not Found.</p>";
}

// Close connection
$conn->close();
}

include("footer.php");

?>