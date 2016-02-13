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

$sql = "SELECT title, abstract, comments, keywords FROM projects";
$result = $conn->query($sql);

/*
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>Project Title: ". $row["title"]. "<br> Comments: ". $row["comments"]. "</p>";
    }
} else {
    echo "<p>Showing 0 results.</p>";
}
*/

//Display Projects
if ($result->num_rows > 0) {
    echo "<table class='table table-striped'>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>\n";
	echo "<table class='table'>\n<caption>". $row["title"]. "</caption>\n";
	echo "<tr><th>Abstract:</th><td>". $row["abstract"]. "</td></tr>\n<tr><th>Comments:</th><td>". $row["comments"]. "</td></tr>\n<tr><th>Keywords:</th><td>". $row["keywords"]. "</td></tr>\n";
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