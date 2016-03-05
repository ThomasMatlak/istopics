<?php
session_start();

$page_title = "Update Project";
include("header.php");

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "<p>Connected successfully</p>";

$sql = "SELECT * FROM projects where id={$_GET["project_id"]}";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
   echo "<p>Project Not Found.</p>";
}

$row = $result->fetch_assoc();

$id = $row["id"];
$title = $row["title"];
$discipline = $row["discipline"];
$abstract = $row["abstract"];
$keywords = $row["keywords"];
$comments = $row["comments"];

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
//user is signed in

//Check that the user has the correct id
$sql = "SELECT userid FROM user_project_connections WHERE projectid={$id}";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$user_id = $row["userid"];

//Close connection
$conn->close();

if ($user_id != $_SESSION["sess_user_id"]) {
   //the correct user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";
     
     //Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

//Print the edit project page

$major_list = file_get_contents("majors.html");

echo <<<EOT
<form id="update_project" action="updateProjectController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <input type="hidden" name="project_id" value="{$id}">
    <div id="check_title">
    <label for="title" class="control-label">Title:</label>
    <input type="text" name="title" id="title" value="{$title}" class="form-control">
    </div>
    <div id="discipline_check">
    <label for="discipline" class="control-label">Major:</label><span id="proj_disc"></span>
    {$major_list}
    </div>
    <label for="abstract" class="control-label">Abstract:</label>
    <textarea cols="80" name="abstract" form="update_project" id="abstract" class="form-control">{$abstract}</textarea>
    <label for="keywords" class="control-label">Keywords:</label>
    <textarea cols="80" name="keywords" form="update_project" id="keywords" class="form-control">{$keywords}</textarea>
    <label for="comments" class="control-label">Additional Comments:</label>
    <textarea cols="80" name="comments" form="update_project" id="comments" class="form-control">{$comments}</textarea>
    <button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>
<form id="delete_project" action="deleteProjectController.php" method="POST">
    <input type="hidden" name="project_id" value="{$id}">
    <button type="submit" class="btn btn-danger">Delete Project</button>
</form>

<script src="js/updateProjectValidation.js"></script>
EOT;
}
else {
     //user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     //Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

include("footer.php")
?>