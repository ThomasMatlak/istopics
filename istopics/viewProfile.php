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

	<a href='updateProfile.php' method='GET' class='btn btn-warning'>Edit Profile</a>
	<hr>
EOT;

$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.abstract, projects.keywords FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE users.id={$user_id} ORDER BY title";

$result = $conn->query($sql);

// Display user's projects
if ($result->num_rows > 0) {
    echo "<ul class='list-unstyled'>";
    
    while($row = $result->fetch_assoc()) {
        $proj_id         = $row["proj_id"];
	$proj_title      = $row["title"];
	$proj_discipline = $row["discipline"];
	$proj_abstract   = $row["abstract"];
	$proj_keywords   = $row["keywords"];

	echo <<<EOT
	<h4>{$first_name}'s Projects</h4>
    	<li>
	<table class='table'>
        <form action='viewProject.php' method='GET'><input type='hidden' name='project_id' value='{$proj_id}'><button type='submit' class='btn btn-link'><strong>{$proj_title}</strong></button></form>
	<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Discipline:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$proj_discipline}</td></tr>
EOT;
	if ($proj_abstract != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}". "abstract' aria-expanded='false' aria-controls='{$proj_id}". "abstract'>Abstract:</a></th><td><div class='collapse' id='{$proj_id}". "abstract'>{$proj_abstract}</div></td></tr>\n";
	}
	if ($proj_keywords != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}". "keywords' aria-expanded='false' aria-controls='{$proj_id}". "keywords'>Keywords:</a></th><td><div class='collapse' id='{$proj_id}". "keywords'>{$proj_keywords}</div></td></tr>\n";
	}
	echo "</table>\n";
	echo "</li>";
    }
    echo "</ul>";
}

}
else {
     echo "<p>User not found.</p>";
}

// Close connection
$conn->close();
}

include("footer.php");
?>