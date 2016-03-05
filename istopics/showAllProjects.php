<?php
/*
* showAllProjects.php
* 
* Display all of the projects in the istopics database.
* Topics are sorted alphabetically be default.
*/

$page_title = "View All Projects";
include("header.php");

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.abstract, projects.keywords, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id ORDER BY title";
$result = $conn->query($sql);

//Display Projects
if ($result->num_rows > 0) {
    echo "<div class='col-lg-offset-5 col-lg-7'><form class='form-inline'><div class='form-group'><input type='text' name='search' id='search' placeholder='Search Projects' class='form-control'></div></form></div>";

    echo "<ul class='list-unstyled col-lg-12' id='results'>";

    $max_proj_id = $conn->query("SELECT id FROM projects ORDER BY id DESC")->fetch_assoc()['id'];

    while($row = $result->fetch_assoc()) {
        $proj_id         = $row["proj_id"];
	$proj_title      = $row["title"];
	$proj_discipline = $row["discipline"];
	$proj_abstract   = $row["abstract"];
	$proj_keywords   = $row["keywords"];
	$user_id         = $row["user_id"];
	$author_name     = $row['first_name']. " ". $row['last_name'];

	echo <<<EOT
	<div id="{$proj_id}">
    	<li>
	<table class='table'>
        <form action='viewProject.php' method='GET'><input type='hidden' name='project_id' value='{$proj_id}'><button type='submit' class='btn btn-link'><strong>{$proj_title}</strong></button></form>
	<caption>{$author_name}</caption>
	<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Major:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$proj_discipline}</td></tr>
EOT;
	if ($proj_abstract != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}". "abstract' aria-expanded='false' aria-controls='{$proj_id}". "abstract'>Abstract:</a></th><td><div class='collapse' id='{$proj_id}". "abstract'>{$proj_abstract}</div></td></tr>\n";
	}
	if ($proj_keywords != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}". "keywords' aria-expanded='false' aria-controls='{$proj_id}". "keywords'>Keywords:</a></th><td><div class='collapse' id='{$proj_id}". "keywords'>{$proj_keywords}</div></td></tr>\n";
	}
	echo "</table>\n";
	echo "</li>";
	echo "</div><hr>";
    }
    echo "</ul>";
    echo "<script src='js/searchAllProjects.js'></script>";
    //echo "<p>{$max_proj_id}</p>";
    echo "<input type='hidden' value='{$max_proj_id}' id='max_proj_id' name='max_proj_id'>";
} else {
    echo "<p>Showing 0 results.</p>";
}

//Close connection
$conn->close();

include("footer.php");
?>