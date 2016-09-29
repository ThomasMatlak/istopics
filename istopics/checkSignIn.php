<?php
/**
 * Check if a user is signed in and return their role if they are sign in
 *
 * To use: place require_once 'checkSignIn.php';
 *         before calling the function
 */

if (!isset($_SESSION)) {session_start();}

function issignedin() {
    if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"])) {
        // user is signed in
	return $_SESSION['sess_user_role'];
    }
    else {
        // user is not signed in
	return -1;
    }
}
