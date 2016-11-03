<?php
/**
 * Delete a project from the istopics database.
 *
 * $_POST['project_id'] - the id of the project to delete
 */

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';
require_once 'checkSignIn.php';
require_once 'project.class.php';

$id = filter_var($_POST["project_id"], FILTER_SANITIZE_STRING);

if (issignedin() != -1) {
// user is signed in

    //Check that the user has the correct id
    $sql = "SELECT userid FROM user_project_connections WHERE projectid={$id}";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $user_id = $row["userid"];

    if (($user_id != $_SESSION["sess_user_id"]) && ($_SESSION["sess_user_role"] != "admin")) {
        // the correct user is not signed in, set error message
      	$_SESSION["error"] = 1;
     	$_SESSION["error_msg"] = "You are not authorized to perform this action.";

     	//Close connection
     	$conn->close();

     	header("Location: /istopics/project/all");
     	exit();
    }

    $project = new Project();
    $project->delete($id, $conn);

    $conn->close();

    $_SESSION["message"] = 2;
    $_SESSION["msg"] = "Project Deleted";

    header("Location: /istopics/project/all");
    exit();
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     header("Location: /istopics/project/all");
     exit();
}
