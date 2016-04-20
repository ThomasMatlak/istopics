<?php
/*
* updateProjectController.php
* 
* Update a project already in the istopics database.
*
* $_POST["project_id"] - the id of the project to update
* $_POST["title"]      - the title of the project to update
* $_POST["proposal"]   - the proposal of the project to update
* $_POST["keywords"]   - the keywords of the project to update
* $_POST["comments"]   - the comments of the project to update
* $_POST["discipline"] - the major of the project to update
*/

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';

$id = $_POST["project_id"];

if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"])) {
// user is signed in

// Check that the user has the correct id
$sql = "SELECT userid FROM user_project_connections WHERE projectid={$id}";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$user_id = $row["userid"];

if (($user_id != $_SESSION["sess_user_id"]) && ($_SESSION["sess_user_role"] != "admin")) {
   // the correct user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";
     
     $stmt->close();
     $conn->close();

     // Redirect to home page
     header("Location: /project/all");
     exit();
}

$title      = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
$proposal   = filter_var($_POST["proposal"], FILTER_SANITIZE_STRING);
$keywords   = filter_var($_POST["keywords"], FILTER_SANITIZE_STRING);
$comments   = filter_var($_POST["comments"], FILTER_SANITIZE_STRING);

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

if (empty($title) || empty(discipline)) {
   $_SESSION["error"] = 1;
   $_SESSION["error_msg"] = "Could Not Update Project";

   // redirect to home page
   header("Location: /project/all");
   exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE projects SET title=?, discipline=?, proposal=?, keywords=?, comments=?, last_updated=now() WHERE id=?");
$stmt->bind_param("ssssss", $title, $discipline, $proposal, $keywords, $comments, $id);

// Submit the SQL statement
$stmt->execute();

$stmt->close();
$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "Succesfully Updated Project";

// Redirect to home page
header("Location: /project?project_id={$id}");
exit();
}
else {
     // user is not signed in, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You must be signed in to perform this action.";
     
     // Redirect to home page
     header("Location: /project/all");
     exit();
}
?>