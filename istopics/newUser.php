<?php
$page_title = "Register";
include("header.php");
?>

<div class="container-fluid">
<form id="new_project" action="newUserController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <div id="check_first_name">
    <label for="first_name" class="control-label">First Name:</label>
    <input type="text" name="first_name" id="first_name" class="form-control">
    </div>
    <div id="check_last_name">
    <label for="last_name" class="control-label">Last Name:</label>
    <input type="text" name="last_name" id="last_name" class="form-control">
    </div>
    <div id="discipline_check">
    <label for="discipline" class="control-label">Major(s):</label><span id="stud_major"></span>
    <?php include("majors.html") ?>
    </div>
    <div id="year_check">
    <label for="year" class="control-label">Graduating Year:</label>
    <input type="number" name="year" id="year" class="form-control" value="<?php echo date("Y"); ?>">
    </div>
    <div id="email_check">
    <label for="email" class="control-label">Email:</label>
    <input type="email" name="email" id="email" class="form-control">
    </div>
    <div id="password_group">
    <label for="password" class="control-label">Password:</label>
    <input type="password" name="password" id="password" class="form-control">
    <label for="confirm_password" class="control-label">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" class="form-control"><span id='password_not_same'></span>
    </div>

    <button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>
</div>

<script>
//Set all fields to default filled state
$('#check_first_name').attr("class", "has-error");
$('#check_last_name').attr("class", "has-error");
$('#discipline_check').attr("class", "has-error");
$('#year_check').attr("class", "has-success");
$('#email_check').attr("class", "has-error");
$('#password_group').attr("class", "has-error");
$('#submit').attr("disabled", "true");

//Check that names are there
$('#first_name').on('input', function() {
    if ($('#first_name').val()) {
        $('#check_first_name').attr("class", "has-success");
    }
    else {
    	$('#check_first_name').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});
$('#last_name').on('input', function() {
    if ($('#last_name').val()) {
        $('#check_last_name').attr("class", "has-success");
    }
    else {
    	$('#check_last_name').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Display the user's selection of major(s)
$('#discipline').on('input', function() {
    if ($('#discipline').val()) {
        $('#stud_major').text($('#discipline').val());
	$('#discipline_check').attr("class", "has-success");
    }
    else {
    	$('#stud_major').text('');
    	$('#discipline_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Check that the graduating year is valid
$('#year').on('input', function() {
    if ($('#year').val()) {
        $('#year_check').attr("class", "has-success");
    }
    else {
    	$('#year_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Check that the email is valid
$('#email').on('input', function() {
//VALIDATE AND AUTO FILL EMAIL
    if ($('#email').val()) {
        $('#email_check').attr("class", "has-success");
    }
    else {
    	$('#email_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Check that passwords match
$('#password').on('input', function() {
    if ($('#confirm_password').val() != $('#password').val()) {
        $('#password_not_same').text('passwords must match');
        $('#password_group').attr("class", "has-error");
        $('#submit').attr("disabled", "true");
    }
    else {
        $('#password_not_same').text('');
        if ($('#first_name').val() != "" && $('#last_name').val() != "") {
	    $('#password_group').attr("class", "has-success");
        }
    }
});
$('#confirm_password').on('input', function() {
    if ($('#confirm_password').val() != $('#password').val()) {
        $('#password_not_same').text('passwords must match');
        $('#password_group').attr("class", "has-error");
        $('#submit').attr("disabled", "true");
    }
    else {
        $('#password_not_same').text('');
        if ($('#first_name').val() != "" && $('#last_name').val() != "") {
	    $('#password_group').attr("class", "has-success");
        }
    }
});

//Check that all fields are filled
$("form :input").on('input', function() {
    if ($('#first_name').val() && $('#last_name').val() && $('#discipline').val() && $('#year').val() && $('#email').val() && $('#password').val() && $('#confirm_password').val()) {
       document.getElementById("submit").disabled = false;
    }
});

</script>

<?php 
include("footer.php")
?>