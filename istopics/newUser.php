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

<script src="js/newUserValidation.js"></script>
<script src="js/generateUserEmail.js"></script>

<?php 
include("footer.php")
?>