<?php
/**
 * Present the user with a form to update their profile information
 */

if (!isset($_SESSION)) {session_start();}

require_once 'checkSignIn.php';

$id = $_GET["user_id"];

if (issignedin() != -1) {

include_once 'db_credentials.php';

// Check that the user has the correct id
$sql = "SELECT id, first_name FROM users WHERE id={$id}";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$user_id = $row["id"];
$first_name = $row["first_name"];

if ((($user_id != $_SESSION["sess_user_id"]) || ($first_name != $_SESSION["sess_user_name"])) && ($_SESSION["sess_user_role"] != "admin")) {
     // the correct user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";

     // Close connection
     $conn->close();

     // Redirect to home page
     header("Location: /project/all");
     exit();
}

$page_title = "Update User Information";
include('header.php');

$sql = "SELECT id, first_name, last_name, email, major, year, role FROM users where id={$user_id}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $first_name = $row["first_name"];
    $last_name  = $row["last_name"];
    $email      = $row["email"];
    $major      = $row["major"];
    $year       = $row["year"];
    $role       = $row["role"];

    if ($user_id != $_SESSION["sess_user_id"] && ($role == 'admin' || $role == 'prof')) {
        $_SESSION["error"] = 1;
     	$_SESSION["error_msg"] = "You are not authorized to perform this action.";

     	// Close connection
     	$conn->close();

     	// Redirect to home page
     	header("Location: /project/all");
     	exit();
    }

    $major_list = file_get_contents("majors.html");

?>
<input type="hidden" id="user_role" value="<?php echo $role ?>">
<form id="update_user" action="/updateProfileController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="form-group">
		<div id="check_first_name">
		<label for="first_name" class="control-label">First Name:</label>
	<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name ?>" required>
	</div>
	<div id="check_last_name">
			<label for="last_name" class="control-label">Last Name:</label>
			<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name ?>" required>
	</div>
<?php
            if ($role == "student") {
?>
	<div id="discipline_check">
			<label for="discipline" class="control-label">Major(s):</label><span id="stud_major"></span>
	<?php echo $major_list ?>
	<input type="hidden" name="st_major" id="st_major" value="<?php echo $major ?>">
</div>
	<div id="year_check">
			<label for="year" class="control-label">Graduating Year:</label>
			<input type="number" name="year" id="year" class="form-control" value="<?php echo $year ?>" required>
		</div>
<?php
            }
?>
			<div id="email_check">
					<label for="email" class="control-label">Email:</label>
					<input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>" required><span id="invalid_email"></span>
				</div>
		<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
		<hr>
			<label for="new_password">Change Password</label>
			<input type="password" id="new_password" name="new_password" class="form-control">
		<button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
		</div>
</form>

<hr>

<form action='/deleteUser.php?user_id=<?php echo $user_id ?>' method='post' class='form-horizontal'>
	<input type='hidden' name='delete_user_id' value='<?php echo $user_id ?>'>
	<input type='hidden' name='delete_user_role' value='<?php echo $role ?>'>
	<button type='submit' class='btn btn-danger'>Delete Your Account</button>
</form>

<script src="/js/updateProfileValidation.js"></script>
<script src="/js/setMajor.js"></script>
<?php
}
else {
     echo "<p>User Not Found.</p>";
}

// Close connection
$conn->close();

}
else {
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action";

     header("Location: /user?user_id={$id}");
     exit();
}

include("footer.php");
