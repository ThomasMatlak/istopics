<?php
$page_title = "Update Project";
include("header.php");

$servername = "localhost";
$username = "istopics";
$password = "password"; //NOTE: CHANGE THE PASSWORD BEFORE GOING INTO PRODUCTION
$dbname = "istopics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "<p>Connected successfully</p>";

$sql = "SELECT * FROM projects where id=". $_GET["project_id"];
$result = $conn->query($sql);

//Display Projects
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

//Close connection
$conn->close();

?>

<div class="container-fluid">
<form id="update_project" action="updateProjectController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <input type="hidden" name="project_id" value="<?php echo $id; ?>">
    <div id="check_title">
    <label for="title" class="control-label">Title:</label>
    <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control">
    </div>
    <div id="discipline_check">
    <label for="discipline" class="control-label">Discipline:</label><span id="proj_disc"></span>
    <?php include("majors.html"); ?>
    </div>
    <label for="abstract" class="control-label">Abstract:</label>
    <textarea cols="80" name="abstract" form="update_project" id="abstract" class="form-control"><?php echo $abstract; ?></textarea>
    <label for="keywords" class="control-label">Keywords:</label>
    <textarea cols="80" name="keywords" form="update_project" id="keywords" class="form-control"><?php echo $keywords; ?></textarea>
    <label for="comments" class="control-label">Additional Comments:</label>
    <textarea cols="80" name="comments" form="update_project" id="comments" class="form-control"><?php echo $comments; ?></textarea>
    <button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>
<form id="delete_project" action="deleteProjectController.php" method="POST">
    <input type="hidden" name="project_id" value="<?php echo $id; ?>">
    <button type="submit" class="btn btn-danger">Delete Project</button>
</form>
</div>

<script>
//Set default field states
$('#check_title').attr("class", "has-success");
$('#discipline_check').attr("class", "has-error");

//Check that the title is there
$('#title').on('input', function() {
    if ($('#title').val()) {
        $('#check_title').attr("class", "has-success");
    }
    else {
    	$('#check_title').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Display the user's selection of major(s)
$('#discipline').on('input', function() {
    if ($('#discipline').val()) {
        $('#proj_disc').text($('#discipline').val());
	$('#discipline_check').attr("class", "has-success");
    }
    else {
    	$('#proj_disc').text('');
    	$('#discipline_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Check that all required fields are filled
$("form :input").on('input', function() {
    if ($('#title').val() && $('#discipline').val()) {
       document.getElementById("submit").disabled = false;
    }
});

</script>

<?php 
include("footer.php")
?>