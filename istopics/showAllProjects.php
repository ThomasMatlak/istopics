<?php
/*
* showAllProjects.php
* 
* Display all of the projects in the istopics database.
* Topics are sorted alphabetically be default.
*/

session_start();

$page_title = "View All Projects";
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

$sql = "SELECT id, title, discipline, abstract, comments, keywords FROM projects ORDER BY title";
$result = $conn->query($sql);


echo "<h1>". $_SESSION["sess_user_name"]. "</h1>";




//Display Projects
if ($result->num_rows > 0) {
    echo "<ul class='list-unstyled'>";
    //echo "<table class='table table-hover'>\n";
    while($row = $result->fetch_assoc()) {
    	echo "<li>";
        //echo "<tr><td>\n";
	echo "<form action='viewProject.php' method='GET'>\n<input type='hidden' name='project_id' value='". $row["id"]. "'><button type='submit' class='btn btn-link'>". $row["title"]. "</button></form><table class='table'>\n";
//Make abstract a one line with a collapse
	echo "<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Discipline:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>". $row["discipline"]. "</td></tr>\n";
	if ($row["abstract"] != NULL) { echo "<tr><th><a role='button' data-toggle='collapse' href='#". $row["id"]. "abstract' aria-expanded='false' aria-controls='". $row["id"]. "abstract'>Abstract:</button></th><td><div class='collapse' id='". $row["id"]. "abstract'>". $row["abstract"]. "</div></td></tr>\n"; }
	if ($row["comments"] != NULL) { echo "<tr><th>Comments:</th><td>". $row["comments"]. "</td></tr>\n"; }
	if ($row["keywords"] != NULL) { echo "<tr><th>Keywords:</th><td>". $row["keywords"]. "</td></tr>\n"; }
	echo "</table>\n";
	echo "</li>";
	//echo "</td></tr>\n";
    }
    echo "</ul>";
    //echo "</table>\n";
} else {
    echo "<p>Showing 0 results.</p>";
}

//Close connection
$conn->close();

echo "</div>";
include("footer.php");
?>