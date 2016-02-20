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

$first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$last_name = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$year = filter_var($_POST["year"], FILTER_SANITIZE_INT);
$major = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$password = $_POST["password"]; //CHANGE TO NOT PLAIN TEXT

if (empty($first_name) || empty($last_name) || empty($year) || empty($major) || empty($email) || empty($password)) {
   //redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

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