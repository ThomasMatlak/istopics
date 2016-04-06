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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id ORDER BY title";

$result = $conn->query($sql);

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

    while($row = $result->fetch_assoc()) {
        $proj_id         = $row["proj_id"];
	$proj_title      = $row["title"];
	$proj_discipline = $row["discipline"];
	$proj_proposal   = $row["proposal"];
	$proj_keywords   = $row["keywords"];
	$user_id         = $row["user_id"];
	$author_name     = $row['first_name']. " ". $row['last_name'];

	echo <<<EOT
	<li>
	    <div id="{$proj_id}" class="panel panel-default">
	        <div class="panel-heading">
                    <form action='viewProject.php' method='GET' class='form-inline'>
		        <input type='hidden' name='project_id' value='{$proj_id}'>
			<button type='submit' class='btn btn-link'><span id="{$proj_id}project_title">{$proj_title}</span></button>
		    </form>
	        </div> <!-- panel heading -->
	        <div class="panel-body">
	            <table class='table'>
	                <caption><span id="{$proj_id}author"><a href='viewProfile.php?user_id={$user_id}' method='GET'>{$author_name}</a></span></caption>
	                <tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Major:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'><div id="{$proj_id}project_major">{$proj_discipline}</div></td></tr>
EOT;
	if ($proj_proposal != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}proposal' aria-expanded='true' aria-controls='{$proj_id}proposal'>Proposal:</a></th><td><div class='collapse in' id='{$proj_id}proposal'>{$proj_proposal}</div></td></tr>\n";
	}
	if ($proj_keywords != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}keywords' aria-expanded='true' aria-controls='{$proj_id}keywords'>Keywords:</a></th><td><div class='collapse in' id='{$proj_id}keywords'>{$proj_keywords}</div></td></tr>\n";
	}
	echo <<<EOT
	            </table>
	        </div> <!-- panel body -->
	    </div> <!-- panel -->
	</li>
EOT;
    }
    echo <<<EOT
        </ul>

        <script src='js/searchAllProjects.js'></script>
        <input type='hidden' value='{$max_proj_id}' id='max_proj_id'>
	<input type='hidden' value='{$result->num_rows}' id='initial_num_results'>
EOT;
} else {
    echo "<p>Showing 0 projects.</p>";
}

// Close connection
$conn->close();

include("footer.php");
?>