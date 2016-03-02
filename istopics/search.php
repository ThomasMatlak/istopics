<?php
/*
* search.php
* 
* Search for projects with specified terms in the title or keywords
*/

$page_title = "Search";
include("header.php");

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

$search_term = $_GET["search_term"];

//Prepare the SQL statement
$stmt = $conn->prepare("SELECT id, title, discipline FROM projects WHERE (project.title LIKE '%?%' OR project.keywords LIKE '%?%')");
$stmt->bind_param("ss", $search_term, $search_term);

//Submit the SQL statement
$result = $stmt->execute();

//Display Projects
if ($result->num_rows > 0) {
    echo "<table class='table table-hover'>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>\n";
	echo "<form action='viewProject.php' method='GET'><table class='table'>\n<input type='hidden' name='project_id' value='". $row["id"]. "'><button type='submit' class='btn btn-link'>". $row["title"]. "</button></form>\n";
	echo "<tr><th>Discipline:</th><td>". $row["discipline"]. "</td></tr>\n";
	echo "<tr><th>Keywords:</th><td>". $row["keywords"]. "</td></tr>\n";
	echo "</table>\n";
	echo "</td></tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>Showing 0 results.</p>";
}

$stmt->close();
$conn->close();

include("footer.php");
?>