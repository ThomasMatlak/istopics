<?php
/*
* login.php
*
* Present the user with a form to sign into a user profile
*/

session_start();
if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
   //user is already signed in

   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "You are already signed in.";

   //redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

$page_title = "Sign In";
include("header.php");
?>

<form class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12" action="loginController.php" method="GET">
  <div class="form-group">
    <label for="email" class="control-label">Email</label>
    <div class="">
      <input type="email" class="form-control" id="email" name="email" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="control-label">Password</label>
    <div class="">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="">
      <div class="checkbox">
        <label>
          <input type="checkbox" id="remember" name="remember"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form>

<?php 
include("footer.php")
?>