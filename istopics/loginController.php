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
$password = _GET["password"];

//Prepare the SQL statement
$stmt = "SELECT id, first_name FROM users WHERE email='$email' AND password='$password'";
$result = conn->query($stmt);

if ($result->num_rows == 1) {
   $row = $result->fetch_assoc();
   echo "Login Succesful";
   $_SESSION["user_id"] = $row["id"];
   $_SESSION["user_name"] = $row["first_name"];
}

//$stmt->bind_param("ss", $email, $password);

//$stmt->execute();



$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>