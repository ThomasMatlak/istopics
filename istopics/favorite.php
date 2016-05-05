<?php
/*
* favorite.php
*
* Change the status of a project's favoritness
*/

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';
require_once 'checkSignIn.php';

if (!isset($_POST['favorite_status']) || (($_POST['favorite_status'] != 'add') && ($_POST['favorite_status'] != 'remove'))) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Could not favorite project.";

    header("Location: /project/all");
    exit();
}
if (!isset($_POST['projectid']) && !filter_var((int) $_POST['projectid'], FILTER_VALIDATE_INT)) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Could not favorite project.";

    header("Location: /project/all");
    exit();
}

if ((issignedin() != -1)) {
    $favorite_status = $_POST['favorite_status'];
    
    $projectid = $_POST['projectid'];
    $userid = $_SESSION['sess_user_id'];

    if ($favorite_status == 'add') {
        $stmt = $conn->prepare("INSERT INTO user_project_favorites (userid, projectid) VALUES (?,?)");
	$stmt->bind_param("ss", $userid, $projectid);

	$stmt->execute();
	$stmt->close();
	$conn->close();
    }
    elseif ($favorite_status == 'remove') {
        $stmt = $conn->prepare("DELETE FROM user_project_favorites WHERE userid=? AND projectid=?");
	$stmt->bind_param("ss", $userid, $projectid);

	$stmt->execute();
	$stmt->close();
	$conn->close();
    }

    $_SESSION["message"] = 1;
    $_SESSION["msg"] = "Project Favorited.";

    header("Location: /project/all");
    exit();

}
else {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "You are not authorized to perform this action.";

    header("Location: /project/all");
    exit();
}
?>