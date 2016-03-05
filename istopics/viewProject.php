<?php
/*
* viewProject.php
* 
* Display the project 
*/

$page_title = "View Project";
include("header.php");

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$proj_id = $_GET["project_id"];
if (!filter_var($proj_id, FILTER_VALIDATE_INT)) {
   echo "<p>That is not a valid project id.</p>";
}
else {
$sql = "SELECT projects.id, projects.title, projects.discipline, projects.abstract, projects.comments, projects.keywords, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE projects.id={$proj_id}";
$result = $conn->query($sql);

// Display Project
if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();

   $author_name = $row["first_name"]. " ". $row["last_name"];
   $major       = $row["discipline"];
   $abstract    = $row["abstract"];
   $comments    = $row["comments"];
   $keywords    = $row["keywords"];

   echo <<<EOT
   	<strong>{$row["title"]}</strong>
	<table class='table table-striped'>\n

   	<caption>{$author_name}</caption>
   	<tr><th>Major:</th><td>{$major}</td></tr>
   	<tr><th>Abstract:</th><td>{$abstract}</td></tr>\n
   	<tr><th>Comments:</th><td>{$comments}</td></tr>\n
   	<tr><th>Keywords:</th><td>{$keywords}</td></tr>\n

   	</table>\n

   	<form action='updateProject.php' method='GET'>\n<input type='hidden' name='project_id' value='{$row["id"]}'><button type='submit' class='btn btn-warning'>Edit Project</button></form>
EOT;

} else {
    echo "<p>Project Not Found.</p>";
}

// Close connection
$conn->close();
}

include("footer.php");

?>