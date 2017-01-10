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
$year = "";

$search = false;

if (isset($_GET['project_title']) && $_GET['project_title'] != '') {
    $project_title = mysqli_real_escape_string($conn, $_GET['project_title']);
    $search = true;
}
if (isset($_GET['discipline']) && $_GET['discipline'] != '') {
    $project_discipline = $_GET['discipline'];

    if (is_array($project_discipline)) {
        foreach ($project_discipline as $disc) {
            $disc = mysqli_real_escape_string($conn, $disc);
        }
    }
    $search = true;
}
if (isset($_GET['year']) && is_numeric(intval($_GET['year']))) {
    $year = $_GET['year'];
    $search = true;
}
if (isset($_GET['author_first_name']) && $_GET['author_first_name'] != '') {
    $author_first_name = mysqli_real_escape_string($conn, $_GET['author_first_name']);
    $search = true;
}
if (isset($_GET['author_last_name']) && $_GET['author_last_name'] != '') {
    $author_last_name = mysqli_real_escape_string($conn, $_GET['author_last_name']);
    $search = true;
}
if (isset($_GET['project_keywords']) && $_GET['project_keywords'] != '') {
    $project_keywords = mysqli_real_escape_string($conn, $_GET['project_keywords']);
    $search = true;
}

if (isset($_GET['project_type']) && count($_GET['project_type']) > 0) {
    $project_type = $_GET['project_type'];

    if (is_array($project_type)) {
        foreach ($project_type as $type) {
            $type = mysqli_real_escape_string($conn, $type);
        }
    }
    $search = true;
}
else {
    $project_type = array();
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
        <label for="year">Year</label>
        <input type="number" name="year" id="year" class="form-control" value="<?php echo $year; ?>">
        <label for="author_first_name" class="control-label">Author's First Name</label>
        <input type="text" name="author_first_name" id="author_first_name" value="<?php echo $author_first_name; ?>" class="form-control">
        <label for="author_last_name" class="control-label">Author's Last Name</label>
        <input type="text" name="author_last_name" id="author_last_name" value="<?php echo $author_last_name; ?>" class="form-control">
        <label for="project_keywords" class="control-label">Keywords</label>
        <input type="text" name="project_keywords" id="project_keywords" value="<?php echo $project_keywords; ?>" class="form-control">
    </div>
    <div class="form-group">
        <label for="project_type">Project Type</label>
        <label class="checkbox-inline">
            <input type="checkbox" name="project_type[]" value="senior" <?php echo (array_search('senior', $project_type) === false) ? '' : 'checked' ?>> Senior I.S.
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="project_type[]" value="junior" <?php echo (array_search('junior', $project_type) === false) ? '' : 'checked' ?>> Junior I.S.
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="project_type[]" value="other" <?php echo (array_search('other', $project_type) === false) ? '' : 'checked' ?>> Other Research Projects
        </label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-warning">Search</button>
    </div>
</form>
<?php

if ($search === true) {
    $sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords, projects.last_updated, projects.project_type, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE ";

    if ($project_title) {
        $sql .= "projects.title LIKE '%{$project_title}%'";
    }
    if ($project_discipline) {
        if ($project_title) {
            $sql .= ' OR ';
        }

        if (! is_array($project_discipline)) {
            $sql .= "projects.discipline LIKE '%{$project_discipline}%'";
        }
        elseif (count($project_discipline) == 1) {
            $sql .= "projects.discipline LIKE '%{$project_discipline[0]}%'";
        }
        else {
            $first_disc = true;
            foreach ($project_discipline as $disc) {
                if ($first_disc !== true) {
                    $sql .= ' OR ';
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
            $sql .= ' OR ';
        }
        $sql .= "users.first_name LIKE '%{$author_first_name}%'";
    }
    if ($author_last_name) {
        if ($project_title || $project_discipline || $author_first_name) {
            $sql .= ' OR ';
        }
        $sql .= "users.last_name LIKE '%{$author_last_name}%'";
    }
    if ($project_keywords) {
        if ($project_title || $project_discipline || $author_first_name || $author_last_name) {
            $sql .= ' OR ';
        }
        $sql .= "projects.keywords LIKE '%{$project_keywords}%'";
    }
    if (count($project_type) > 0) {
        if ($project_title || $project_discipline || $author_first_name || $author_last_name || $project_keywords) {
            $sql .= ' AND ';
        }
        $sql .= '(';

        $first_type = true;
        foreach($project_type as $type) {
            if ($first_type !== true) {
                $sql .= ' OR ';
            }
            else {
                $first_type = false;
            }
            $sql .= "projects.project_type LIKE '%{$type}%'";
        }

        $sql .= ')';
    }
    if ($year) {
        if ($project_title || $project_discipline || $author_first_name || $author_last_name || $project_keywords || count($project_type) > 0) {
            $sql .= ' AND ';
        }
        $sql .= "YEAR(projects.date_created)={$year}";
    }

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
            $project_type    = $row['project_type'];

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

            display_project($proj_id, $author_name, $user_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, "", $last_updated, false, true, $fav_status, $project_type, $conn);
        }
        echo "</ul>";
    }
    else {
        echo "<p>Did not find any projects. Try different search terms.</p>";
    }
}

include 'footer.php';
