<?php
/*
* updateProjectController.php
* 
* Update a project already in the istopics database.
*/

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["project_id"];
$title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$discipline = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$abstract = filter_var($_POST["abstract"], FILTER_SANITIZE_STRING);
$keywords = filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
$comments = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

if (empty($title) || empty(discipline)) {
   //redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

//Prepare the SQL statement
$stmt = $conn->prepare("UPDATE projects SET title=?, discipline=?, abstract=?, keywords=?, comments=? WHERE id=?");
$stmt->bind_param("ssssss", $title, $discipline, $abstract, $keywords, $comments, $id);

//Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>