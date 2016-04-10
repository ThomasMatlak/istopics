<?php
/*
* newProjectController.php
* 
* Add a new project to the istopics database.
*/

if (!isset($_SESSION)) {session_start();}

if (!isset($_SESSION["sess_user_id"]) || !isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"]) && ($_SESSION["sess_user_role"] == "student")) {
   // user is not signed in, set error message
   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "You are not authorized to perform this action.";
     
   // Redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

require_once 'db_credentials.php';

// Set variables and sanitize input
$title      = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$proposal   = filter_var($_POST["proposal"], FILTER_SANITIZE_STRING);
$keywords   = filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
$comments   = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

$discipline = "";
$discipline_array = $_POST["discipline"];
$last_discipline  = end($discipline_array);

foreach ($discipline_array as $selected_major) {
    $selected_major = filter_var($selected_major, FILTER_SANITIZE_STRING);
    $discipline = $discipline. $selected_major;
    if ($selected_major != $last_discipline) {
        $discipline = $discipline. ", ";
    }
}

if (empty($title) || empty($discipline)) {
   // redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO projects (title, discipline, proposal, keywords, comments, date_created, last_updated) VALUES (?, ?, ?, ?, ?, now(), now())");
$stmt->bind_param("sssss", $title, $discipline, $proposal, $keywords, $comments);

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