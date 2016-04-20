<?php
/*
* loginController.php
* 
* Sign a user in using their email and password and create a session
*/

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $email = filter_var($_SESSION["email"], FILTER_SANITIZE_EMAIL);
    $pass  = $_SESSION["password"];

    unset($_SESSION['email']);
    unset($_SESSION['password']);
}
else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $pass  = $_POST["password"];
}
$sql = "SELECT id, first_name, role, password FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();
   
   if (!password_verify($pass, $row["password"])) {
       // Close connections
       $conn->close();

       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "Username or password does not match.";

       // Redirect to login page
       header("Location: /signin");
       exit();
   }

   // set session variables
   $_SESSION["sess_user_id"]   = $row["id"];
   $_SESSION["sess_user_name"] = $row["first_name"];
   $_SESSION["sess_user_role"] = $row["role"];
   
   // reset error variables
   unset($_SESSION["error"]);
   unset($_SESSION["error_message"]);

   // Close connections
   $conn->close();

   // Redirect to appropriate page
   if ($_GET["just_registered"] == "student") {
      header("Location: /project/new");
      exit();
   }
   else if ($_GET["just_registered"] == "prof") {
      header("Location: /project/all");
      exit();
   }
   else {
   	header("Location: /project/all");
   	exit();
   }

} else {
    // Close connections
    $conn->close();

    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Username or password does not match.";

    // Redirect to login page
    header("Location: /signin");
    exit();
}

?>