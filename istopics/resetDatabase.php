<?php
/*
* resetDatabase.php
*
* Reset the database by removing all non-admin users, projects, and connections between the two
*/

if (!isset($_SESSION)) {session_start();}

require_once 'db_credentials.php';

if (isset($_SESSION['sess_user_id']) && isset($_SESSION['sess_user_name']) && isset($_SESSION['sess_user_role']) && ($_SESSION['sess_user_role'] == 'admin')) {
   $sql = "TRUNCATE TABLE projects";
   if (!$conn->query($sql)) {
     $_SESSION["error"] = 3;
     $_SESSION["error_msg"] = "Error Removing projects";
     
     header("Location: adminInterface.php");
     exit();
   }

   $sql = "DELETE FROM users WHERE role!='admin' AND role!='prof'";
   if (!$conn->query($sql)) {
     $_SESSION["error"] = 3;
     $_SESSION["error_msg"] = "Error Removing users";
     
     header("Location: adminInterface.php");
     exit();
   }

   $sql = "TRUNCATE TABLE user_project_connections";
   if (!$conn->query($sql)) {
     $_SESSION["error"] = 3;
     $_SESSION["error_msg"] = "Error Removing user_project_connections";
     
     header("Location: adminInterface.php");
     exit();
   }

   $_SESSION["error"] = 2;
   $_SESSION["error_msg"] = "Succesfully Reset the Database";
     
   header("Location: adminInterface.php");
   exit();

}
else {
     // user is not authorized, set error message
     $_SESSION["error"] = 1;
     $_SESSION["error_msg"] = "You are not authorized to perform this action.";
     
     // Redirect to home page
     header("Location: showAllProjects.php");
     exit();
}
?>