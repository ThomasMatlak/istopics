<?php
/*
* showAllProjects.php
* 
* Display all of the projects in the istopics database.
* Topics are sorted alphabetically be default.
*/

$page_title = "View All Projects";
include("header.php");
echo "\n<div class='container-fluid'>";
?>

<?php
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

$sql = "SELECT id, title, discipline, abstract, comments, keywords FROM projects ORDER BY title";
$result = $conn->query($sql);

//Display Projects
if ($result->num_rows > 0) {
    echo "<table class='table table-hover'>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>\n";
	echo "<form action='viewProject.php' method='GET'>\n<input type='hidden' name='project_id' value='". $row["id"]. "'><button type='submit' class='btn btn-link'>". $row["title"]. "</button></form><table class='table'>\n";
//Make abstract a one line with a collapse
	echo "<tr><th>Discipline:</th><td>". $row["discipline"]. "</td></tr>\n";
	echo "<tr><th>Abstract:</th><td>". $row["abstract"]. "</td></tr>\n";
	echo "<tr><th>Comments:</th><td>". $row["comments"]. "</td></tr>\n";
	echo "<tr><th>Keywords:</th><td>". $row["keywords"]. "</td></tr>\n";
	echo "</table>\n";
	echo "</td></tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>Showing 0 results.</p>";
}

//Close connection
$conn->close();

echo "</div>";
include("footer.php");
?>