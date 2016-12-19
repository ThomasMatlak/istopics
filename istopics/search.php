<?php
/**
 * Search for projects with specified terms in the title or keywords
 */

$page_title = "Advanced Search";
include("header.php");

require_once 'db_credentials.php';
require_once 'displayProject.php';

$project_title = "";
$project_discipline = "";
$author_first_name = "";
$author_last_name = "";
$project_keywords = "";

$search = false;

if (isset($_GET['project_title'])) {
    $project_title = mysqli_real_escape_string($conn, $_GET['project_title']);
    $search = true;
}
if (isset($_GET['discipline'])) {
    $project_discipline = $_GET['discipline'];
    foreach ($project_discipline as $disc) {
        $disc = mysqli_real_escape_string($conn, $disc);
    }
    $search = true;
}
if (isset($_GET['author_first_name'])) {
    $author_first_name = mysqli_real_escape_string($conn, $_GET['author_first_name']);
    $search = true;
}
if (isset($_GET['author_last_name'])) {
    $author_last_name = mysqli_real_escape_string($conn, $_GET['author_last_name']);
    $search = true;
}
if (isset($_GET['project_keywords'])) {
    $project_keywords = mysqli_real_escape_string($conn, $_GET['project_keywords']);
    $search = true;
}

?>
<h1>Advanced Search</h1>

<form action="/istopics/project/search" method="GET" class="form-horizontal">
    <div class="form-group">
        <label for="project_title" class="control-label">Project Title</label>
        <input type="text" name="project_title" id="project_title" value="<?php echo $project_title; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="discipline" class="control-label">Major/Discipline</label>
        <?php include 'majors.html'; ?>
    </div>
    <div class="form-group">
        <label for="author_first_name" class="control-label">Author's First Name</label>
        <input type="text" name="author_first_name" id="author_first_name" value="<?php echo $author_first_name; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="author_last_name" class="control-label">Author's Last Name</label>
        <input type="text" name="author_last_name" id="author_last_name" value="<?php echo $author_last_name; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="project_keywords" class="control-label">Keywords</label>
        <input type="text" name="project_keywords" id="project_keywords" value="<?php echo $project_keywords; ?>" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-warning">Search</button>
    </div>
</form>
<?php

if ($search === true) {
    $sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords, projects.last_updated, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE ";

    if ($project_title) {
        $sql .= "projects.title LIKE '%{$project_title}%'";
    }
    if ($project_discipline) {
        if ($project_title) {
            // $sql .= ' AND ';
            $sql .= ' OR ';
        }

        if (count($project_discipline) == 1) {
            $sql .= "projects.discipline LIKE '%{$project_discipline[0]}%'";
        }
        else {
            $first_disc = true;
            foreach ($project_discipline as $disc) {
                if ($first_disc !== true) {
                    $sql .= " OR ";
                }
                else {
                    $first_disc = false;
                }
                $sql .= "projects.discipline LIKE '%{$disc}%'";
            }
        }
    }
    if ($author_first_name) {
        if ($project_title || $project_discipline) {
            // $sql .= ' AND ';
            $sql .= ' OR ';
        }
        $sql .= "users.first_name LIKE '%{$author_first_name}%'";
    }
    if ($author_last_name) {
        if ($project_title || $project_discipline || $author_first_name) {
            // $sql .= ' AND ';
            $sql .= ' OR ';
        }
        $sql .= "users.last_name LIKE '%{$author_last_name}%'";
    }
    if ($project_keywords) {
        if ($project_title || $project_discipline || $author_first_name || $author_last_name) {
            // $sql .= ' AND ';
            $sql .= ' OR ';
        }
        $sql .= "projects.keywords LIKE '%{$project_keywords}%'";
    }

    // echo $sql;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<p>Showing <span id='num_projects'>{$result->num_rows}</span> <span id='result_or_results'>" .(($result->num_rows == 1) ? 'project' : 'projects') ."</span>.</p>";

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
        
            display_project($proj_id, $author_name, $user_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, "", $last_updated, false, true, $fav_status, $conn);
        }
        echo "</ul>";
    }
    else {
        echo "<p>Did not find any projects. Try different search terms.</p>";
    }
}

include 'footer.php';
