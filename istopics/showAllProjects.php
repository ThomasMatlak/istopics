<?php
/*
* showAllProjects.php
* 
* Display all of the projects in the istopics database.
* Topics are sorted alphabetically by default.
*/

$page_title = "View All Projects";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';

$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id ORDER BY title";

$result = $conn->query($sql);

echo <<<EOT
    <script src='js/ellipsify.js'></script>
    <script src='js/expand_contract_pk.js'></script>
EOT;

// Display Projects
if ($result->num_rows > 0) {
    echo "<form class='form-inline'><div class='form-group'><input type='text' name='search' id='search' placeholder='Search Projects' class='form-control'></div><span class='help-block'>Search by keywords, title, major, author, or proposal</span></form>";

    if ($result->num_rows == 1) {
        echo "<p>Showing <span id='num_projects'>{$result->num_rows}</span> <span id='result_or_results'>project</span>.</p>";
    }
    else {
        echo "<p>Showing <span id='num_projects'>{$result->num_rows}</span> <span id='result_or_results'>projects</span>.</p>";
    }

    echo "<span id='no_results_msg'></span>";

    echo "<ul class='list-unstyled' id='results'>";

    $max_proj_id = $conn->query("SELECT id FROM projects ORDER BY id DESC")->fetch_assoc()['id'];

    $all_keywords = array();

    while($row = $result->fetch_assoc()) {
        $proj_id         = $row["proj_id"];
	$proj_title      = $row["title"];
	$proj_discipline = $row["discipline"];
	$proj_proposal   = $row["proposal"];
	$proj_keywords   = $row["keywords"];
	$user_id         = $row["user_id"];
	$author_name     = $row['first_name']. " ". $row['last_name'];
	
	display_project($proj_id, $author_name, $user_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, "", false, true);

	$keywords_list = explode(",", $proj_keywords);

        foreach ($keywords_list as $word) {
            if (!in_array($word, $all_keywords)) {
	        array_push($all_keywords, chop($word, "."));
	    }
        }

    }
    echo <<<EOT
        </ul>

	<script src='js/searchAllProjects.js'></script>

        <input type='hidden' value='{$max_proj_id}' id='max_proj_id'>
	<input type='hidden' value='{$result->num_rows}' id='initial_num_results'>
EOT;

    echo "<input type='hidden' id='all_keywords' value='";

    foreach ($all_keywords as $keyword) {
        echo "{$keyword} ";
    }

    echo "'>";

    echo <<<EOT
        <link rel="stylesheet" href="css/jquery-ui.min.css">
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/autocompleteSearch.js"></script>
EOT;

} else {
    echo "<p>Showing 0 projects.</p>";
}

// Close connection
$conn->close();

include("footer.php");
?>