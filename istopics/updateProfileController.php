<?php
/**
 * Update a user profile
 *
 * $_POST["user_id"]      - the user id of the user to update
 * $_POST["first_name"]   - the first name of the user to update
 * $_POST["last_name"]    - the last name of the user to update
 * $_POST["email"]        - the email of the user to update
 * $_POST["year"]         - the class year of the user to update
 * $_POST["discipline"]   - the major of the user to update
 * $_POST["new_password"] - the password of the user to update
 */

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';
require_once 'checkSignIn.php';
require_once 'userprofile.class.php';

if (issignedin() != -1) {
// user is signed in

    $user_id    = $_POST["user_id"];
    $first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
    $last_name  = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
    $year       = filter_var($_POST["year"], FILTER_SANITIZE_STRING);
    $email      = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if ($_POST['other_discipline'] != '') {
        $discipline = filter_var($_POST['other_discipline'], FILTER_SANITIZE_STRING);
    }
    else {
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
    }

    if (empty($first_name) || empty($last_name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Some input is not valid
    	$_SESSION["error"] = 1;
    	$_SESSION["error_msg"] = "Your input was invalid.";

	    header("Location: /istopics/user/{$user_id}");
    	exit();
    }
    if (($_SESSION["sess_user_role"] == "student") && (empty($discipline) || empty($year))) {
        // Some input is not valid
    	$_SESSION["error"] = 1;
    	$_SESSION["error_msg"] = "Your input was invalid.";

	    header("Location: /istopics/user/{$user_id}");
    	exit();
    }

    // Check that user is authorized to update profile
    if (($_SESSION["sess_user_id"] != $user_id) && ($_SESSION["sess_user_role"] != "admin")) {
        // user is not authorized, set error message
        $_SESSION["error"] = 1;
        $_SESSION["error_msg"] = "You are not authorized to perform this action.";

        header("Location: /istopics/user/{$user_id}");
        exit();
    }

    $user_profile = new UserProfile();
    if (isset($_POST["new_password"]) && $_POST["new_password"] != "") {
        $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

        $user_profile->update($user_id, $first_name, $last_name, $email, $discipline, $_SESSION['sess_user_role'], $new_password, $year, $conn);
    }
    else {
        $user_profile->update($user_id, $first_name, $last_name, $email, $discipline, $_SESSION['sess_user_role'], false, $year, $conn);
    }

    $conn->close();

    $_SESSION["message"] = 1;
    $_SESSION["msg"] = "Succesfully Updated User Profile";

    header("Location: /istopics/user/{$user_id}");
    exit();
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";

     // Redirect to home page
     header("Location: /istopics/user/{$user_id}");
     exit();
}
