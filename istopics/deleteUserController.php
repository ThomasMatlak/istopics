<?php
/**
 * Delete a user from the database
 *
 * $_POST['delete_user_id']   - the id of the user to be deleted
 * $_POST['delete_user_role'] - the role of the user to be deleted
 */

if (!isset($_SESSION)) {session_start();}

$id   = $_POST["delete_user_id"];
$role = $_POST["delete_user_role"];

require_once 'checkSignIn.php';
require_once 'userprofile.class.php';

if (issignedin() != -1) {
    require_once 'db_credentials.php';

    $user_profile = new UserProfile();

    // Check that the user has the correct id
    $result = $user_profile->get($id, $conn);
    $user_id = $result['id'];
    $first_name = $result['first_name'];

    if ((($user_id != $_SESSION["sess_user_id"]) || ($first_name != $_SESSION["sess_user_name"])) && ($_SESSION["sess_user_role"] != "admin")) {
        // the correct user is not signed in, set error message
     	$_SESSION["error"] = 1;
     	$_SESSION["error_msg"] = "You are not authorized to perform this action.";

     	// Close connection
     	$conn->close();

	    header("Location: /project/all");
     	exit();
    }

    if ($user_id != $_SESSION["sess_user_id"] && ($role == 'admin' || $role == 'prof')) {
        $_SESSION["error"] = 1;
    	$_SESSION["error_msg"] = "You are not authorized to perform this action.";

    	// Close connection
    	$conn->close();

    	header("Location: /project/all");
    	exit();
    }

    // Prepare the SQL statement
    $user_profile->delete($id, $conn);

    session_unset();

    $_SESSION["message"] = 2;
    $_SESSION["msg"] = "User Deleted";

    header("Location: /project/all");
    exit();
}

else {
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action";

     header("Location: /user?user_id={$id}");
     exit;
}
