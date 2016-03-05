<?php
/*
* updateProfileController.php
*
* Update a user profile
*/

session_start();

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
// user is signed in

$user_id    = $_SESSION["sess_user_id"];
$first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$last_name  = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$discipline = filter_var($_POST["discipline"], FILTER_SANITIZE_STRING);
$year       = filter_var($_POST["year"], FILTER_SANITIZE_STRING);
$email      = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

if (empty($first_name) || empty($last_name) || empty($discipline) || empty($year) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
   // Some input is not valid
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "Your input was invalid.";
     
     // Redirect to home page
     header("Location: viewProfile.php");
     exit();
}

$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, major=?, year=?, email=? WHERE id=?");
$stmt->bind_param("ssssss", $first_name, $last_name, $discipline, $year, $email, $user_id);

// Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "Succesfully Updated User Profile";

// Redirect to home page
header("Location: viewProfile.php");
exit();
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: viewProfile.php");
     exit();
}
?>