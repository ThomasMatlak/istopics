<?php
/*
* updateProjectController.php
* 
* Update a project already in the istopics database.
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

$id = $_POST["project_id"];
$title = $_POST["title"];
$discipline = $_POST["discipline"];
$abstract = $_POST["abstract"];
$keywords = $_POST["keywords"];
$comments = $_POST["comments"];

if ($title == "" || discipline == "") {
   //display error message
   echo '<script language="javascript">';
   echo 'alert("Could not update project with blank title or discipline")';
   echo '</script>';

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