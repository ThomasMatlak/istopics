<?php
/*
* adminInterface.php
*
* Provide an admin interface such that the database can be edited and reset
*/

session_start();

$page_title = "Database Administration";
include("header.php");

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"]) && ($_SESSION["sess_user_role"] == "admin")) {
// user is signed in as an admin

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

if (!isset($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "That's not an email";
     
    header("Location: showAllProjects.php");
    exit();
}

require_once 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
if (!($stmt = $conn->prepare("UPDATE users SET role='admin' WHERE email=?"))) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Something went wrong.";

    header("Location: adminInterface.php");
    exit();
}
if (!($stmt->bind_param("s", $email))) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Something went wrong.";

    header("Location: adminInterface.php");
    exit();
}

// Submit the SQL statement
if (!($stmt->execute())) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Something went wrong.";

    header("Location: adminInterface.php");
    exit();
}

// Check if any changes were made
if (mysqli_affected_rows($conn) <= 0) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "No changes were made. Perhaps user {$email} doesn't exist?";

    header("Location: adminInterface.php");
    exit();
}

$stmt->close();
$conn->close();

$_SESSION['message'] = 1;
$_SESSION['msg'] = "Succesfully promoted {$email} to an admin";

header("Location: adminInterface.php");
exit();

}
else {
     // user is not signed in as an admin, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}

include("footer.php");
?>