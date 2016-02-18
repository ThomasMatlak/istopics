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
    <label for="discipline" class="control-label">Major(s):</label><span id="stud_major"></span>
    <?php include("majors.html") ?>

    <label for="year" class="form-control">Graduating Year:</label>
    <input type="number" name="year" id="year" class="form-control" value="<?php echo date("Y"); ?>">

    <label for="email" class="control-label">Email:</label>
    <input type="email" name="email" id="email" class="form-control">
    
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
//Check that no fields are empty
$('#submit').attr("disabled", "true");
/*
$('form :input').change(function() {
    if () {
       $('#submit').attr("disabled", false");
    }
    else {
    	 
    }
});*/

//Check that names are there
$('#first_name').on('input', function() {
    $('#check_first_name').attr("class", "has-success");
});
$('#last_name').on('input', function() {
    $('#check_last_name').attr("class", "has-success");
});

//Display the user's selection of major(s)
$('#discipline').on('input', function() {
    $('#stud_major').text($('#discipline').val());
    
});

//Check that the email is valid


//Check that passwords match
$('#confirm_password').on('input', function() {
    if ($('#confirm_password').val() != $('#password').val()) {
        $('#password_not_same').text('passwords must match');
        $('#password_group').attr("class", "has-error");
        $('#submit').attr("disabled", "true");
    }
    else {
        $('#password_not_same').text('');
        $('#password_group').attr("class", "has-success");
        if ($('#first_name').val() != "" && $('#last_name').val() != "") {
            document.getElementById("submit").disabled = false;
        }
    }
});
</script>

<?php 
include("footer.php")
?>