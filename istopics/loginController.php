<?php
/*
* loginController.php
* 
* Sign a user in using their email and password and create a session
*/

session_start();

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
$email = $_GET["email"];
$pass = $_GET["password"];

//Prepare the SQL statement
$sql = "SELECT id, first_name FROM users WHERE email=? AND password=?";

//Attempt to prepare the statement

if ($stmt = $conn->prepare($sql)) {
   $stmt->bind_param("ss", $email, $password);

   $stmt->execute();

   $stmt->bind_result($user_id, $user_name);

   while ($stmt->fetch()) {
       $_SESSION["sess_user_id"] = $user_id;
       $_SESSION["sess_user_name"] = $user_name;
   }
   $stmt->close();
}

//Close connections
$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>