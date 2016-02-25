<?php
/*
* showAllProjects.php
* 
* Display all of the projects in the istopics database.
* Topics are sorted alphabetically be default.
*/

$page_title = "View All Projects";
include("header.php");
echo <<<EOT
     <div class='container-fluid'>
     <h1>{$page_title}</h1>
EOT;
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
$sql = "SELECT projects.id, projects.title, projects.discipline, projects.abstract, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id ORDER BY title";
$result = $conn->query($sql);

//Display Projects
if ($result->num_rows > 0) {
    echo "<ul class='list-unstyled'>";
    
    while($row = $result->fetch_assoc()) {
        $proj_id = $row["id"];
	$proj_title = $row["title"];
	$proj_discipline = $row["discipline"];
	$proj_abstract = $row["abstract"];
	$author_name = $row['first_name']. " ". $row['last_name'];

	echo <<<EOT
	<hr>
    	<li>
	<table class='table'>
        <form action='viewProject.php' method='GET' class='form-inline'>\n<div class='form-group'><input type='hidden' name='project_id' value='{$proj_id}'><caption><button type='submit' class='btn btn-link'><strong>{$proj_title}</strong></button></div></form>{$author_name}<caption>
	<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Discipline:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$proj_discipline}</td></tr>
EOT;
	if ($proj_abstract != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}". "abstract' aria-expanded='false' aria-controls='{$proj_id}". "abstract'>Abstract:</a></th><td><div class='collapse' id='{$proj_id}". "abstract'>{$proj_abstract}</div></td></tr>\n";
	}
	echo "</table>\n";
	echo "</li>";
	
    }
    echo "</ul>";
} else {
    echo "<p>Showing 0 results.</p>";
}

//Close connection
$conn->close();

echo "</div>";
include("footer.php");
?>