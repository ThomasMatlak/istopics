<?php
/*
* viewProject.php
* 
* Display the project 
*/

$page_title = "View Project";
include("header.php");
echo "\n<div class='container-fluid'>";

$servername = "localhost";
$username = "istopics";
$password = "password"; //NOTE: CHANGE THE PASSWORD BEFORE GOING INTO PRODUCTION
$dbname = "istopics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$proj_id = $_GET["project_id"]

$sql = "SELECT projects.id, projects.title, projects.discipline, projects.abstract, projects.comments, projects.keywords, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE projects_id=$proj_id";
$result = $conn->query($sql);

//Display Project
if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();
   echo "<table class='table table-striped'>\n";

   echo "<caption>". $row["title"]. "</caption>";
   echo "<tr><th>Discipline:</th><td>". $row["discipline"]. "</td></tr>";
   echo "<tr><th>Abstract:</th><td>". $row["abstract"]. "</td></tr>\n";
   echo "<tr><th>Comments:</th><td>". $row["comments"]. "</td></tr>\n";
   echo "<tr><th>Keywords:</th><td>". $row["keywords"]. "</td></tr>\n";

   echo "</table>\n";

   echo "<form action='updateProject.php' method='GET'>\n<input type='hidden' name='project_id' value='". $row["id"]. "'><button type='submit' class='btn btn-warning'>Edit Project</button></form>";
} else {
    echo "<p>Project Not Found.</p>";
}

//Close connection
$conn->close();

echo "</div>";
include("footer.php");
?>