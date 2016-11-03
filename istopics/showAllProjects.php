<?php
/**
 * Display all of the projects in the istopics database.
 * Topics are sorted alphabetically by default.
 */

$page_title = "View All Projects";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';

$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords, projects.last_updated, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE users.year";

// it is assumed IS projects take place during a student's graduating year
if (isset($_GET['year']) && is_numeric($_GET['year'])) {
    $sql .= "=" .$_GET['year'];
}
elseif ($_GET['year'] === '') {
    $sql .= "=YEAR(CURDATE()) OR users.year=(YEAR(CURDATE()) + 1) ";
}
else { // show everything
    $sql .= ">0";
}

// choose how the projects are sorted
if (isset($_GET['type']) && $_GET['type'] == 'senior') { // only retrieve Senior IS projects
    $sql .= "AND projects.project_type='senior'";
}
else if (isset($_GET['type']) && $_GET['type'] == 'junior') { // only retrive Junior IS projects
    $sql .= "AND projects.project_type='junior'";
}
else if (isset($_GET['type']) && $_GET['type'] == 'other') { // only retrieve other projects
    $sql .= "AND projects.project_type='other'";
}
else {} // retrive all projects

$sql .= " ORDER BY ";

if (isset($_GET['order']) && ($_GET['order'] == 'title')) {
    $sql .= "title";
}
else if (isset($_GET['order']) && ($_GET['order'] == 'time')) {
    $sql .= "projects.last_updated DESC";
}
else {
     // default sorting of projects
     $sql .= "projects.last_updated DESC";
}

$result = $conn->query($sql);

?>
    <script src='/js/ellipsify.js'></script>
    <script src='/js/expand_contract_pk.js'></script>
    <script src='/js/projectTemplate.js'></script>
<?php

// Display Projects
if ($result->num_rows > 0) {
    echo "<form class='form-inline'><div class='form-group'><input type='text' name='search' id='search' placeholder='Search Projects' class='form-control'></div><span class='help-block'>Search by keywords, title, major, or author. Separate search terms with commas.</span></form>";

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

    $project_json = '\'{"projects":[';
    $first = true; // add a comma before all entries except the first one

    while($row = $result->fetch_assoc()) {
        $proj_id         = $row["proj_id"];
        $proj_title      = addslashes($row["title"]);
        $proj_discipline = addslashes($row["discipline"]);
        $proj_proposal   = addslashes($row["proposal"]);
        $proj_keywords   = addslashes($row["keywords"]);
        $user_id         = $row["user_id"];
        $author_name     = addslashes($row['first_name']. " ". $row['last_name']);
        $last_updated    = $row['last_updated'];
        
        display_project($proj_id, $author_name, $user_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, "", $last_updated, false, true, $conn);

        $keywords_list = explode(",", $proj_keywords);

        ($first === false) ? $project_json .= ',' : $first = false;

        $project_json .= "{";
        $project_json .= "\"id\":\"{$proj_id}\",\"title\":\"{$proj_title}\",\"discipline\":\"{$proj_discipline}\",\"proposal\":\"{$proj_proposal}\",\"keywords\":\"{$proj_keywords}\",\"user_id\":\"{$user_id}\",\"author_name\":\"{$author_name}\",\"last_updated\":\"{$last_updated}\"";
        $project_json .= "}";

        foreach ($keywords_list as $word) {
            if (!in_array($word, $all_keywords)) {
                array_push($all_keywords, rtrim($word, "."));
            }
        }
    }

    $project_json .= "]}'";
?>
    </ul>
<script>
    var p = JSON.parse(<?php echo $project_json; ?>);
</script>

<script src='/js/searchAllProjects.js'></script>

	<input type='hidden' value='<?php echo $result->num_rows; ?>' id='initial_num_results'>
<?php

    echo "<input type='hidden' id='all_keywords' value='";

    foreach ($all_keywords as $keyword) {
        echo "{$keyword},";
    }

    echo "'>";

?>
<link rel="stylesheet" property='stylesheet' href="/css/jquery-ui.min.css">
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/autocompleteSearch.js"></script>
<?php

} else {
    echo "<p>Showing 0 projects.</p>";
}

// Close connection
$conn->close();

include("footer.php");
