<?php
/*
* newUser.php
*
* Present the user with a form to create a new user profile
*/

$page_title = "Register";
include("header.php");
?>

<form id="new_user" action="newUserController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="form-group">
        <label for="studentSelect">I am a: </label>
	<label class="radio-inline">
    	    <input type="radio" name="stud_or_faculty" id="studentSelect" value="student" onclick="stud_faculty_toggle();" checked> Student
        </label>
        <label class="radio-inline">
            <input type="radio" name="stud_or_faculty" id="facultySelect" value="faculty" onclick="stud_faculty_toggle();"> Faculty or Staff Member
    	</label>
    </div>
    <div id="check_first_name" class="form-group">
        <label for="first_name" class="control-label">First Name:</label>
    	<input type="text" name="first_name" id="first_name" class="form-control">
    </div>
    <div id="check_last_name" class="form-group">
        <label for="last_name" class="control-label">Last Name:</label>
        <input type="text" name="last_name" id="last_name" class="form-control">
    </div>
    <div id="discipline_check" class="form-group">
        <label for="discipline" class="control-label">Major(s):</label> <span id="stud_major"></span>
        <?php include("majors.html") ?>
    </div>
    <div id="year_check" class="form-group">
        <label for="year" class="control-label">Graduating Year:</label>
        <input type="number" name="year" id="year" class="form-control" value="<?php echo date("Y"); ?>">
    </div>
    <div id="email_check" class="form-group">
        <label for="email" class="control-label">Email:</label>
    	<input type="email" name="email" id="email" class="form-control visible-lg-inline visible-md-inline visible-sm-inline visible-xs-inline" placeholder="Use your Wooster email">
    </div>
    <div id="password_group" class="form-group">
        <label for="password" class="control-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Please use a strong password">
    	<label for="confirm_password" class="control-label">Confirm Password:</label>
    	<input type="password" name="confirm_password" id="confirm_password" class="form-control"><span id='password_not_same'></span>
    </div>
    <button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
</form>

<script src="js/newUserValidation.js"></script>

<?php 
include("footer.php")
?>