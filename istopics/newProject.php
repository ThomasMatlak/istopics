<?php
/**
 * Present the user with a form to create a new project
 */

if (!isset($_SESSION)) {session_start();}

require_once 'checkSignIn.php';

$page_title = "Add a New Project";
include("header.php");

if (issignedin() == 'student') {
// user is signed in as a student

    // Get the student's major
    
    require_once 'db_credentials.php';

    $sql = "SELECT major FROM users WHERE id={$_SESSION['sess_user_id']}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

		$user_major = $row["major"];
    }

    // Print the new project page

    $major_list = file_get_contents("majors.html");

?>
	<h3>Add a new project</h3>
<form id="new_project" action="/istopics/newProjectController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="form-group">
		<label for="project_type">Project Type</label>
		<label class="checkbox-inline">
			<input type="radio" name="project_type" value="senior" checked> Senior I.S.
		</label>
		<label class="checkbox-inline">
			<input type="radio" name="project_type" value="junior"> Junior I.S.
		</label>
		<label class="checkbox-inline">
			<input type="radio" name="project_type" value="other"> Other Research Project
		</label>
		<div id="check_title">
			<label for="title" class="control-label">Title:</label>
			<input type="text" name="title" id="title" class="form-control" placeholder="Your project's working title" required>
		</div>
		<div id="discipline_check">
			<label for="discipline" class="control-label">Major:</label> <span id="stud_major"></span>
			<?php echo $major_list ?>
		<input type="hidden" name="st_major" id="st_major" value="<?php echo $user_major; ?>" required>
		</div>
		<label for="proposal" class="control-label">Project Proposal:</label>
		<textarea rows="5" cols="80" name="proposal" form="new_project" id="proposal" class="form-control" placeholder="Your IS proposal (optional)"></textarea>
		<div id="check_keywords">
			<label for="keywords" class="control-label">Keywords:</label>
		<textarea rows="1" cols="80" name="keywords" form="new_project" id="keywords" class="form-control" placeholder="Type keywords that describe major ideas and methodologies of your IS topic, separated by commas. E.g. beekeeping, ethnography" required></textarea>
		</div>
		<label for="comments" class="control-label">Additional Comments:</label>
		<textarea rows="2" cols="80" name="comments" form="new_project" id="comments" class="form-control" placeholder="Are there particular skills you are looking for in a collaborative partner? Is there a specific discipline you are hoping to work with?"></textarea>
		<button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
	</div>
</form>

<script src="/istopics/js/newProjectValidation.js"></script>
<script src="/istopics/js/setMajor.js"></script>
<?php
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";
     
     // Redirect to home page
     header("Location: /istopics/project/all");
     exit();
}

include("footer.php");
