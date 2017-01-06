<?php
/**
 * Add a new project to the istopics database.
 *
 * $_POST["title"]        - the title of the project to add
 * $_POST["proposal"]     - the proposal of the project to add
 * $_POST["keywords"]     - the keywords of the project to add
 * $_POST["comments"]     - the comments of the project to add
 * $_POST["discipline"]   - the major of the project to add
 * $_POST["project_type"] - the type of the project to add
 */

if (!isset($_SESSION)) {session_start();}

require_once 'checkSignIn.php';

if (issignedin() != 'student') {
    // user is not signed in, set error message
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "You are not authorized to perform this action.";

    header("Location: /istopics/project/all");
    exit();
}

require_once 'db_credentials.php';
require_once 'project.class.php';

// Set variables and sanitize input
$title    = filter_var(trim($_POST["title"]), FILTER_SANITIZE_SPECIAL_CHARS);
$proposal = filter_var(trim($_POST["proposal"]), FILTER_SANITIZE_SPECIAL_CHARS);
$proposal = str_replace("\n", ' ', $proposal); // remove newline characters
$keywords = filter_var(trim($_POST["keywords"]), FILTER_SANITIZE_SPECIAL_CHARS);
$comments = filter_var(trim($_POST["comments"]), FILTER_SANITIZE_SPECIAL_CHARS);
$proj_t   = filter_var(trim($_POST["project_type"]), FILTER_SANITIZE_SPECIAL_CHARS);

if ($_POST['other_discipline'] != '') {
    $discipline = filter_var($_POST['other_discipline'], FILTER_SANITIZE_STRING);
}
else {
    $discipline = "";
    $discipline_array = $_POST["discipline"];
    $last_discipline  = end($discipline_array);

    foreach ($discipline_array as $selected_major) {
        $selected_major = filter_var($selected_major, FILTER_SANITIZE_SPECIAL_CHARS);
        $discipline = $discipline. $selected_major;
        if ($selected_major != $last_discipline) {
            $discipline = $discipline. ", ";
        }
}
}

if (empty($title) || empty($discipline)) {
    header("Location: /istopics/project/all");
    exit();
}

$project = new Project();
$project->create($title, $proposal, $keywords, $comments, $discipline, $proj_t, $_SESSION['sess_user_id'], $conn);

$_SESSION["message"] = 1;
$_SESSION["msg"] = "Succecfully Added Project";

header("Location: /istopics/project/all");
exit();
