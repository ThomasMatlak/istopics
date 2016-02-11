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

$title = $_POST["title"];
$abstract = $_POST["abstract"];
$keywords = $_POST["keywords"];
$comments = $_POST["comments"];

//Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO projects (title, abstract, keywords, comments) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $abstract, $keywords, $comments);

//Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>