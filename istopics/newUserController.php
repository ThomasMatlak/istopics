<?php
/*
* newUserController.php
* 
* Add a new user to the istopics database.
*/

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$last_name  = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$year       = filter_var($_POST["year"], FILTER_SANITIZE_STRING);
$major      = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$email      = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$password   = $_POST["password"]; //CHANGE TO NOT PLAIN TEXT
$role       = "student";

if (empty($first_name) || empty($last_name) || empty($year) || empty($major) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "Could not create user.";
   // redirect to home page
   header("Location: showAllProjects.php");
   exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, major, year, password, role) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss", $first_name, $last_name, $email, $major, $year, $password, $role);

// Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "New User Succesfully Added";

// Redirect to login page
header("Location: login.php");
exit();
?>