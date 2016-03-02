<?php

session_start();

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {

include_once 'db_credentials.php';

$id = $_SESSION["sess_user_id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Check that the user has the correct id
$sql = "SELECT id, first_name FROM users WHERE id={$id}";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$user_id = $row["id"];
$first_name = $row["first_name"];

if ($user_id != $_SESSION["sess_user_id"] || $first_name != $_SESSION["sess_user_name"]) {
   //the correct user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";

     //Close connection
     $conn->close();

     //Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

$page_title = "Update User Information";
include('header.php');

$sql = "SELECT first_name, last_name, email, major, year FROM user where id={$user_id}";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
   echo "<p>User Not Found.</p>";
}

$row = $result->fetch_assoc();

$first_name = row["first_name"];
$last_name = row["last_name"];
$email = row["email"];
$major = row["major"];
$year = row["year"];



}
else {
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action";

     /Redirect to home page
     header("Location: showAllProjects.php");
     exit;
}

include("footer.php")
?>