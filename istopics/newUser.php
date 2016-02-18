<?php
$page_title = "Register";
include("header.php");
?>

<div class="container-fluid">
<form id="new_project" action="newUserController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <label for="first_name" class="control-label">First Name:</label>
    <input type="text" name="first_name" id="first_name" class="form-control">
    <label for="last_name" class="control-label">Last Name:</label>
    <input type="text" name="last_name" id="last_name" class="form-control">
    <label for="discipline" class="control-label">Major(s):</label>
    <?php include("majors.html") ?>
    <label for="year" class="form-control">Graduating Year:</label>
    <input type="number" name="year" id="year" class="form-control" value="<?php echo date("Y"); ?>">
    <label for="email" class="control-label">Email:</label>
    <input type="email" name="email" id="email" class="form-control">
    <label for="password" class="control-label">Password:</label>
    <input type="password" name="password" id="password" class="form-control">

    <!-- VERIFY THAT PASSWORD AND VERIFY_PASSWORD ARE THE SAME -->

    <label for="confirm_password" class="control-label">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
    <button type="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>
</div>

<?php 
include("footer.php")
?>