<?php
/*
* newProject.php
* 
* Add a new project to the istopics database.
*/

$servername = "localhost";
$username = "istopics";
$password = "password"; //NOTE: CHANGE THE PASSWORD BEFORE GOING INTO PRODUCTION
$dbname = "istopics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Set variables and sanitize input
$title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$discipline = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$abstract = filter_var($_POST["abstract"], FILTER_SANITIZE_STRING);
$keywords = filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
$comments = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

if (empty($title) || empty($discipline)) {
   //redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

//Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO projects (title, discipline, abstract, keywords, comments) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $discipline, $abstract, $keywords, $comments);

//Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>