<?php
/*
* newProject.php
*
* Present the user with a form to create a new project
*/

session_start();

$page_title = "Add a New Project";
include("header.php");

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
// user is signed in

// Print the new project page

$major_list = file_get_contents("majors.html");

echo <<<EOT
<form id="new_project" action="newProjectController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <div id="check_title">
    <label for="title" class="control-label">Title:</label>
    <input type="text" name="title" id="title" class="form-control">
    </div>
    <div id="discipline_check">
    <label for="discipline" class="control-label">Major:</label><span id="proj_disc"></span>
    {$major_list}
    </div>
    <label for="proposal" class="control-label">Project Proposal:</label>
    <textarea rows="5" cols="80" name="proposal" form="new_project" id="proposal" class="form-control"></textarea>
    <label for="keywords" class="control-label">Keywords:</label>
    <textarea rows="1" cols="80" name="keywords" form="new_project" id="keywords" class="form-control"></textarea>
    <label for="comments" class="control-label">Additional Comments:</label>
    <textarea rows="2" cols="80" name="comments" form="new_project" id="comments" class="form-control"></textarea>
    <button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>

<script src="js/newProjectValidation.js"></script>

EOT;
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

include("footer.php")
?>