<?php

session_start();

$page_title = "Add a New Project";
include("header.php");

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
//user is signed in

//Print the new project page

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
    <label for="abstract" class="control-label">Abstract:</label>
    <textarea rows="5" cols="80" name="abstract" form="new_project" id="abstract" class="form-control"></textarea>
    <label for="keywords" class="control-label">Keywords:</label>
    <textarea rows="1" cols="80" name="keywords" form="new_project" id="keywords" class="form-control"></textarea>
    <label for="comments" class="control-label">Additional Comments:</label>
    <textarea rows="2" cols="80" name="comments" form="new_project" id="comments" class="form-control"></textarea>
    <button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>

<script>
//Set all fields to default filled state
$('#check_title').attr("class", "has-error");
$('#discipline_check').attr("class", "has-error");
$('#submit').attr("disabled", "true");

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