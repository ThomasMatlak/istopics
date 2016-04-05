<?php
/*
* newUserController.php
* 
* Add a new user to the istopics database.
*/

session_start();

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stu_or_fac = $_POST["stud_or_faculty"];
$first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$last_name  = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$email      = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); //. "@wooster.edu";
$password   = password_hash($_POST["password"], PASSWORD_DEFAULT);

if (empty($stu_or_fac) || (empty($first_name) || empty($last_name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password) || !preg_match("/@wooster.edu/", $email))) {
   if (empty($first_name)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter your first name";
   }
   else if (empty($last_name)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter your last name";
   }
   else if (empty($email)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter your email";
   }
   else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "That's not a valid email";
   }
   else if (!preg_match("/@wooster.edu/", $email)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You must use a Wooster email";
   }
   else if (empty($password)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter a password";
   }

   // redirect to home page
   header("Location: newUser.php");
   exit();
}
if (($stu_or_fac == "student")) {
    $year  = filter_var($_POST["year"], FILTER_SANITIZE_STRING);
    $major = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
    if (empty($year) || empty($major)) {
        if (empty($year)) {
            $_SESSION["error"] = 1;
            $_SESSION["error_msg"] = "You didn't enter your class year";
        }
        else if (empty($major)) {
            $_SESSION["error"] = 1;
            $_SESSION["error_msg"] = "You didn't enter your major";
        }
   	header("Location: newUser.php");
   	exit();
    }
    $role = "student";
}
else if (($stu_or_fac == "faculty")) {
    $role = "prof";
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