<?php
/*
* updateProjectController.php
* 
* Update a project already in the istopics database.
*/

session_start();

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["project_id"];

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
// user is signed in

// Check that the user has the correct id
$sql = "SELECT userid FROM user_project_connections WHERE projectid={$id}";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$user_id = $row["userid"];

if ($user_id != $_SESSION["sess_user_id"]) {
   // the correct user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";
     
     $stmt->close();
     $conn->close();

     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

$title      = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$discipline = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$abstract   = filter_var($_POST["abstract"], FILTER_SANITIZE_STRING);
$keywords   = filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
$comments   = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

if (empty($title) || empty(discipline)) {
   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "Could Not Update Project";

   // redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE projects SET title=?, discipline=?, abstract=?, keywords=?, comments=? WHERE id=?");
$stmt->bind_param("ssssss", $title, $discipline, $abstract, $keywords, $comments, $id);

// Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "Succesfully Updated Project";

// Redirect to home page
header("Location: showAllProjects.php");
exit();
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}
?>