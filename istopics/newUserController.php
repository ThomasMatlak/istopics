<?php
/**
 * Add a new user to the istopics database.
 *
 * $_POST["stud_or_faculty"] - is the user a student of faculty member?
 * $_POST["first_name"]      - the first name of the user to add
 * $_POST["last_name"]       - the last name of the user to add
 * $_POST["email"]           - the email of the user to add
 * $_POST["year"]            - the class year of the user to add
 * $_POST["discipline"]      - the major of the user to add
 * $_POST["password"]        - the password of the user to add
 */

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';

$stu_or_fac = $_POST["stud_or_faculty"];
$first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
$last_name  = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
$email      = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); //. "@wooster.edu";
$password   = password_hash($_POST["password"], PASSWORD_DEFAULT);

if (empty($stu_or_fac) || (empty($first_name) || empty($last_name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password) || !preg_match("/@wooster.edu/", $email))) {
   if (empty($first_name)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter your first name";
   }
   else if (empty($last_name)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter your last name";
   }
   else if (empty($email)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter your email";
   }
   else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "That's not a valid email";
   }
   else if (!preg_match("/@wooster.edu/", $email)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You must use a Wooster email";
   }
   else if (empty($password)) {
       $_SESSION["error"] = 1;
       $_SESSION["error_msg"] = "You didn't enter a password";
   }

   // redirect to home page
   header("Location: /register");
   exit();
}
if (($stu_or_fac == "student")) {
    $year  = filter_var($_POST["year"], FILTER_SANITIZE_STRING);

    $major = "";
    $discipline_array = $_POST["discipline"];
    $last_discipline  = end($discipline_array);

    foreach ($discipline_array as $selected_major) {
        $selected_major = filter_var($selected_major, FILTER_SANITIZE_STRING);
    	$major = $major. $selected_major;
    	if ($selected_major != $last_discipline) {
            $major = $major. ", ";
    	}
    }

    if (empty($year) || empty($major)) {
        if (empty($year)) {
            $_SESSION["error"] = 1;
            $_SESSION["error_msg"] = "You didn't enter your class year";
        }
        else if (empty($major)) {
            $_SESSION["error"] = 1;
            $_SESSION["error_msg"] = "You didn't enter your major";
        }
   	header("Location: /register");
   	exit();
    }
    $role = "student";
}
else if (($stu_or_fac == "faculty")) {
    $role = "prof";
}

// Prepare the SQL statement
if (!($stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, major, year, password, role) VALUES (?,?,?,?,?,?,?)"))) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Something went wrong.";

    header("Location: /register");
    exit();
}
if (!($stmt->bind_param("sssssss", $first_name, $last_name, $email, $major, $year, $password, $role))) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Something went wrong.";

    header("Location: /regitser");
    exit();
}

// Submit the SQL statement
if (!($stmt->execute())) {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "Error creating new user. This email is probably already in use.";

    header("Location: /register");
    exit();
}

$stmt->close();
$conn->close();

$_SESSION["message"] = 1;
$_SESSION["msg"] = "New User Succesfully Added";

// Sign the user in
$_SESSION['email'] = $email;
$_SESSION['password'] = $_POST['password'];

header("Location: /loginController.php?just_registered={$role}");
exit();
