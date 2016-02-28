<?php
/*
* deleteProjectController.php
* 
* Delete a project from the istopics database.
*/

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["project_id"];

//Prepare the SQL statement
$stmt = $conn->prepare("DELETE from projects WHERE id=?");
$stmt->bind_param("s", $id);

//Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>