<?php
/*
* viewProfile.php
*
* View a user profile
*/

session_start();

$page_title = "View Profile";
include("header.php");

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["user_id"])) {
   $user_id = $_GET["user_id"];
}
else {
   $user_id = $_SESSION["sess_user_id"];
}

if (!filter_var($user_id, FILTER_VALIDATE_INT)) {
   echo "<p>That is not a valid user id.</p>";
}
else {
$sql = "SELECT id, first_name, last_name, major, year, email FROM users WHERE id={$user_id}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();

   $user_id    = $row["id"];
   $first_name = $row["first_name"];
   $last_name  = $row["last_name"];
   $major      = $row["major"];
   $year       = $row["year"];
   $email      = $row["email"];

   echo <<<EOT
   	<strong>{$first_name} {$last_name}</strong>
	<table class='table table-striped'>

	<tr><th>Major(s):</th><td>{$major}</td></tr>
	<tr><th>Graduation Year:</th><td>{$year}</td></tr>
	<tr><th>Email:</th><td>{$email}</td></tr>

	</table>

	<form action='updateProfile.php' method='GET'><input type='hidden' name='user_id' value='{$user_id}'><button type='submit' class='btn btn-warning'>Edit Profile</button></form>
EOT;
/*
$sql = "SELECT projects.id, projects.title, projects.discipline FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections=users.id WHERE users.id={$user_id} ORDER BY title";

$result = $conn->query($sql);

// Display user's projects
if ($result->num_rows > 0) {
   
}*/

}
else {
     echo "<p>User not found.</p>";
}

// Close connection
$conn->close();
}

include("footer.php");
?>