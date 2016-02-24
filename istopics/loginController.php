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

$sql = "SELECT id, first_name FROM users WHERE email='$email' AND password='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();
   
   $_SESSION["sess_user_id"] = $row["id"];
   $_SESSION["sess_user_name"] = $row["first_name"];
   
   //Close connections
   $conn->close();

   //Redirect to home page
   header("Location: showAllProjects.php");
   exit();

} else {
    //Close connections
    $conn->close();

    //Redirect to home page
    header("Location: showAllProjects.php");
    exit();
}

?>