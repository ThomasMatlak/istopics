<?php
/*
* newProjectController.php
* 
* Add a new project to the istopics database.
*/

session_start();

if (!isset($_SESSION["sess_user_id"]) || !isset($_SESSION["sess_user_name"])) {
   // user is not signed in, set error message
   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
   // Redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set variables and sanitize input
$title      = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$discipline = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$abstract   = filter_var($_POST["abstract"], FILTER_SANITIZE_STRING);
$keywords   = filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
$comments   = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

if (empty($title) || empty($discipline)) {
   // redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO projects (title, discipline, abstract, keywords, comments) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $discipline, $abstract, $keywords, $comments);

// Submit the SQL statement
$stmt->execute();

$proj_id = $conn->insert_id;

$stmt->close();

// Link the project to the currently signed in user
$stmt = $conn->prepare("INSERT INTO user_project_connections (userid, projectid) VALUES (?, ?)");

$user_id = $_SESSION["sess_user_id"];
$stmt->bind_param("ss", $user_id, $proj_id);

$stmt->execute();

$stmt->close();

$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "Succecfully Added Project";

// Redirect to home page
header("Location: showAllProjects.php");
exit();
?>