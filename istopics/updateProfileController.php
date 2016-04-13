<?php
/*
* updateProfileController.php
*
* Update a user profile
*/

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"])) {
// user is signed in

//$user_id    = $_SESSION["sess_user_id"];
$user_id    = $_POST["user_id"];
$first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$last_name  = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$year       = filter_var($_POST["year"], FILTER_SANITIZE_STRING);
$email      = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

$discipline = "";
$discipline_array = $_POST["discipline"];
$last_discipline  = end($discipline_array);

foreach ($discipline_array as $selected_major) {
    $selected_major = filter_var($selected_major, FILTER_SANITIZE_STRING);
    $discipline = $discipline. $selected_major;
    if ($selected_major != $last_discipline) {
        $discipline = $discipline. ", ";
    }
}

if (empty($first_name) || empty($last_name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Some input is not valid
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Your input was invalid.";
     
    header("Location: /user");
    exit();
}
if (($_SESSION["sess_user_role"] == "student") && (empty($discipline) || empty($year))) {
    // Some input is not valid
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Your input was invalid.";
     
    header("Location: /user");
    exit();
}

// Check that user is authorized to update profile
if (($_SESSION["sess_user_id"] != $user_id) && ($_SESSION["sess_user_role"] != "admin")) {
   // user is not authorized, set error message
   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "You are not authorized to perform this action.";

   // Redirect to home page
   header("Location: /user");
   exit();
}

$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, major=?, year=?, email=? WHERE id=?");
$stmt->bind_param("ssssss", $first_name, $last_name, $discipline, $year, $email, $user_id);

// Submit the SQL statement
$stmt->execute();

if (isset($_POST["new_password"]) && $_POST["new_password"] != "") {
    // update password

    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("ss", $new_password, $user_id);

    // Submit the SQL statement
    $stmt->execute();
}

$stmt->close();
$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "Succesfully Updated User Profile";

header("Location: /user");
exit();
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: /user");
     exit();
}
?>