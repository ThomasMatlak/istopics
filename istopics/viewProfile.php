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
$sql = "SELECT id, first_name, last_name, major, year, email, role FROM users WHERE id={$user_id}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();

   $user_id    = $row["id"];
   $first_name = $row["first_name"];
   $last_name  = $row["last_name"];
   $major      = $row["major"];
   $year       = $row["year"];
   $email      = $row["email"];
   $role       = $row["role"];

   echo <<<EOT
   	<h3>{$first_name} {$last_name}</h3>
	<table class='table table-striped'>
EOT;
	if ($role == "student") {
	    echo <<<EOT
	        <tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Major(s):</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$major}</td></tr>
		<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Graduation Year:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$year}</td></tr>
EOT;
	}
   echo <<<EOT
	<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Email:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$email}</td></tr>

	</table>

	<form action='updateProfile.php' method='GET'>
	    <input type='hidden' name='user_id' id='user_id' value='{$user_id}'>
	    <button class='btn btn-warning'>Edit Profile</button>
	</form>
EOT;

$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.keywords FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE users.id={$user_id} ORDER BY title";

$result = $conn->query($sql);

// Display user's projects
if ($result->num_rows > 0) {
   echo <<<EOT
   	<hr>
	<h4>{$first_name}'s Projects</h4>

   	<ul class='list-unstyled'>
EOT;

   while($row = $result->fetch_assoc()) {
   	$proj_id         = $row["proj_id"];
	$proj_title      = $row["title"];
	$proj_major      = $row["discipline"];
	$proj_proposal   = $row["proposal"];
	$proj_keywords   = $row["keywords"];

	echo <<<EOT
    	<li>
	    <div class='panel panel-default'>
	        <div class='panel-heading'>
                    <form action='viewProject.php' method='GET' class='form-inline'>
    	                <input type='hidden' name='project_id' value='{$proj_id}'><button type='submit' class='btn btn-link form-control'><span>{$proj_title}</span></button>
		    </form>
	        </div> <!-- panel heading -->
	        <div class='panel-body'>
		    <table class='table'>
	                <tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Major:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$proj_major}</td></tr>
EOT;
	if ($proj_proposal != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}proposal' aria-expanded='true' aria-controls='{$proj_id}proposal'>Proposal:</a></th><td><div class='collapse in' id='{$proj_id}proposal'>{$proj_proposal}</div></td></tr>\n";
	}
	if ($proj_keywords != NULL) {
	   echo "<tr><th><a role='button' data-toggle='collapse' href='#{$proj_id}". "keywords' aria-expanded='true' aria-controls='{$proj_id}". "keywords'>Keywords:</a></th><td><div class='collapse in' id='{$proj_id}". "keywords'>{$proj_keywords}</div></td></tr>\n";
	}
	echo  <<<EOT
	            </table>
	        <div> <!-- panel body -->
	    <div> <!-- panel -->
	</li>
EOT;
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