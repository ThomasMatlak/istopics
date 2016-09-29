<?php
/**
 * Search for projects with specified terms in the title or keywords
 */

$page_title = "Search";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';

$search_term = filter_var($_GET["search_term"], FILTER_SANITIZE_STRING);

$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords, projects.last_updated, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE (projects.title LIKE '%{$search_term}%' OR projects.keywords LIKE '%{$search_term}%' OR projects.discipline LIKE '%{$search_term}%' OR projects.proposal LIKE '%{$search_term}%') ORDER BY title";

$result = $conn->query($sql);

// Display Projects
if ($result->num_rows > 0) {
    if ($result->num_rows == 1) {
        echo "<p>Showing <span id='num_projects'>{$result->num_rows}</span> <span id='result_or_results'>project</span>.</p>";
    }
    else {
        echo "<p>Showing <span id='num_projects'>{$result->num_rows}</span> <span id='result_or_results'>projects</span>.</p>";
    }

    echo "<ul class='list-unstyled' id='results'>";

    while($row = $result->fetch_assoc()) {
    	$proj_id         = $row["proj_id"];
	$proj_title      = $row["title"];
	$proj_discipline = $row["discipline"];
	$proj_proposal   = $row["proposal"];
	$proj_keywords   = $row["keywords"];
	$user_id         = $row["user_id"];
	$author_name     = $row['first_name']. " ". $row['last_name'];
	$last_updated    = $row['last_updated'];
	
	display_project($proj_id, $author_name, $user_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, "", $last_updated, false, true);
    }
    echo "</ul>";
}
else {
    echo "<p>Showing 0 projects.</p>";
}

$conn->close();

include("footer.php");
