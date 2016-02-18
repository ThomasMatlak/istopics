<?php
/*
* newUserController.php
* 
* Add a new user to the istopics database.
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

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$year = $_POST["year"];
$major = $_POST["discipline"];
$email = $_POST["email"];
$password = $_POST["password"]; //CHANGE TO NOT PLAIN TEXT
/*
if () {
   //display error message
   echo '<script language="javascript">';
   echo 'alert("")';
   echo '</script>';

   //redirect to home page
   header("Location: showAllProjects.php");
   exit();
}*/

//Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, major, year, password) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("ssssss", $first_name, $last_name, $email, $major, $year, $password);

//Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

//Redirect to home page
header("Location: showAllProjects.php");
exit();
?>