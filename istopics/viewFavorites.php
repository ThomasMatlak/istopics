<?php
/**
 * Display the user's favorited projects
 */

if (!isset($_SESSION)) {session_start();}

$page_title = "View Favorites";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';
require_once 'checkSignIn.php';

if (issignedin() == -1) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "You must be signed in to perform this action.";

    header("Location: /istopics/project/all");
    exit();
}

$view = 'list';
if (isset($_GET['view']) && ($_GET['view'] == 'tabular' || $_GET['view'] == 't')) {
    $view = 'tabular';
}

$user_id = $_SESSION['sess_user_id'];

$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.last_updated, projects.keywords, projects.project_type FROM projects INNER JOIN user_project_favorites ON projects.id=user_project_favorites.projectid INNER JOIN users ON user_project_favorites.userid=users.id WHERE users.id=? ORDER BY title";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();

$result = $stmt->get_result();
$stmt->close();

?>
<script src='/istopics/js/ellipsify.js'></script>
<script src='/istopics/js/expand_contract_pk.js'></script>
<?php

// Display user's favorited projects
if ($result->num_rows > 0) {
?>
<hr>
<h4>Your Favorite Projects</h4>
<ul class="nav nav-tabs">
    <li <?php echo ($view == 'list') ? 'class="active"' : '' ?>><a <?php echo ($view == 'list') ? '' : 'href="./favorites"';?>>List</a></li>
    <li <?php echo ($view == 'tabular') ? 'class="active"' : '' ?>><a <?php echo ($view == 'tabular') ? '' : 'href="./favorites?view=t"';?>>Tabular</a></li>
</ul>
<?php
    if ($view == 'list') {
        echo "<ul class='list-unstyled' id='results'>";
    }
    elseif ($view == 'tabular') {
?>
    <!--<span class="help-block">Click columns headers to sort. To sort by multiple columns, hold <kbd>Shift</kbd>.</span>-->
    <table class='table table-bordered table-hover' id='results'>
    <thead>
    <tr>
        <th>Project Title</th>
        <th>Author</th>
        <th>Major</th>
        <th>Project Type</th>
        <th>Project Year</th>
    </tr>
    </thead>
    <tbody>
<?php
    }
    while($row = $result->fetch_assoc()) {
        $proj_id           = $row["proj_id"];
        $proj_title        = addslashes($row["title"]);
        $proj_major        = addslashes($row["discipline"]);
        $proj_proposal     = addslashes($row["proposal"]);
        $proj_keywords     = addslashes($row["keywords"]);
        $last_updated      = $row["last_updated"];
        $project_type      = $row['project_type'];

        $author_info_sql = "SELECT users.id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON users.id=user_project_connections.userid WHERE user_project_connections.projectid={$proj_id}";

        $author_info_row = $conn->query($author_info_sql)->fetch_assoc();

        $author_id   = $author_info_row["id"];
        $author_name = addslashes($author_info_row['first_name']. " ". $author_info_row['last_name']);

        if (issignedin() != -1) {
            $userid = $_SESSION['sess_user_id'];
            $sql1 = "SELECT userid, projectid FROM user_project_favorites WHERE projectid={$proj_id} AND userid={$userid}";

            $result1 = $conn->query($sql1);

            if ($result1->num_rows > 0) {
                $fav_status = true;
            }
            else {
                $fav_status = false;
            }
        }
        else {
            $fav_status = false;
        }

        if ($view == 'list') {
            display_project($proj_id, $author_name, $author_id, $proj_title, $proj_major, $proj_proposal, $proj_keywords, "", $last_updated, false, true, $fav_status, $project_type, $conn);
        }
        elseif ($view == 'tabular') {
            display_project_tabular($proj_id, $author_name, $author_id, $proj_title, $proj_major, $proj_proposal, $proj_keywords, "", $last_updated, false, true, $fav_status, $project_type, $conn);
        }
    }

    $max_proj_id = $conn->query("SELECT id FROM projects ORDER BY id DESC")->fetch_assoc()['id'];

    if ($view == 'list') {
        echo "</ul>";
    }
    elseif ($view == 'tabular') {
        echo "</tbody></table>";
    }

    echo "<input type='hidden' value='{$max_proj_id}' id='max_proj_id'>";
}
else {
    echo "<p>You do not have any favorited projects.</p>";
}

include('footer.php');
