<?php
/*
* updateProfile.php
*
* Present the user with a form to update their profile information
*/

// ADD CHANGE PASSWORD OPTION

session_start();

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {

include_once 'db_credentials.php';

$id = $_SESSION["sess_user_id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check that the user has the correct id
$sql = "SELECT id, first_name FROM users WHERE id={$id}";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$user_id = $row["id"];
$first_name = $row["first_name"];

if ($user_id != $_SESSION["sess_user_id"] || $first_name != $_SESSION["sess_user_name"]) {
   // the correct user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";

     // Close connection
     $conn->close();

     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

$page_title = "Update User Information";
include('header.php');

$sql = "SELECT id, first_name, last_name, email, major, year FROM users where id={$user_id}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $first_name = $row["first_name"];
    $last_name  = $row["last_name"];
    $email      = $row["email"];
    $major      = $row["major"];
    $year       = $row["year"];

    echo <<<EOT
    	 <form id="update_user" action="updateProfileController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
 	     <div class="form-group">
    	         <div id="check_first_name">
    		     <label for="first_name" class="control-label">First Name:</label>
		     <input type="text" name="first_name" id="first_name" class="form-control" value="{$first_name}">
    		 </div>
    		 <div id="check_last_name">
                     <label for="last_name" class="control-label">Last Name:</label>
    	             <input type="text" name="last_name" id="last_name" class="form-control" value="{$last_name}">
    	   	 </div>
    		 <div id="discipline_check">
                     <label for="discipline" class="control-label">Major(s):</label><span id="stud_major"></span>
		     
EOT;
		     include("majors.html");
    echo <<<EOT
	  	 </div>
    		 <div id="year_check">
                     <label for="year" class="control-label">Graduating Year:</label>
                     <input type="number" name="year" id="year" class="form-control" value="{$year}">
    	         </div>
    		 <div id="email_check">
                     <label for="email" class="control-label">Email:</label>
                     <input type="email" name="email" id="email" class="form-control" value="{$email}">
                 </div>
		<button type="submit" id="submit" class="btn btn-warning form-control">Submit</button>
     	    </div>
	</form>

	<script src="js/updateProfileValidation.js"></script>
EOT;
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

     // Redirect to home page
     header("Location: showAllProjects.php");
     exit;
}
?>

<?php
include("footer.php");
?>