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
//echo "<p>Connected successfully</p>";

$sql = "SELECT * FROM projects where id=". $_GET["project_id"];
$result = $conn->query($sql);

//Display Projects
if ($result->num_rows > 0) {
    echo "<table class='table table-striped'>\n";
    while($row = $result->fetch_assoc()) {
        echo "<caption>". $row["title"]. "</caption>";
	echo "<tr><th>Discipline:</th><td>". $row["discipline"]. "</td></tr>";
	echo "<tr><th>Abstract:</th><td>". $row["abstract"]. "</td></tr>\n";
	echo "<tr><th>Comments:</th><td>". $row["comments"]. "</td></tr>\n";
	echo "<tr><th>Keywords:</th><td>". $row["keywords"]. "</td></tr>\n";
	echo "<form action='updateProject.php' method='GET'><table class='table'>\n<input type='hidden' name='project_id' value='". $row["id"]. "'><button type='submit' class='btn btn-warning'>Edit Project</button></form>";
    }
    echo "</table>\n";
} else {
    echo "<p>Project Not Found.</p>";
}

//Close connection
$conn->close();

echo "</div>";
include("footer.php");
?>