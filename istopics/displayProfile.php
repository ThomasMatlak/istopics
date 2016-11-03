<?php
/**
 * Provides a function to output a profile list item
 *
 * To use this function, place
 *     require_once 'displayProfile.php';
 * before calling display_profile()
 */

function display_profile($user_id, $name, $show_name, $major, $year, $email, $role, $show_role) {
/**
 * @param int    $user_id   - the id of the user being displayed
 * @param string $name      - the user's name
 * @param bool   $show_name - show the user's name? (T/F)
 * @param string $major     - the user's major, if they are a student
 * @param int    $year      - the user's class year, if they are a student
 * @param string $email     - the user's email
 * @param string $role      - the user's role
 * @param bool   $show_role - show the user's role? (T/F)
 */

?>
<li class='<?php echo $user_id; ?> well'>
<table class='table'>
<?php

	    if ($show_name == true) {
	        echo "<tr><th>Name:</th><td>{$name}</td></tr>";
	    }

	    if ($show_role == true) {
                echo "<tr><th>User Role:</th><td>{$role}</td></tr>";
	    }

	    if ($role == "student") {
?>
	<tr><th class='col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2'>Major(s):</th><td class='col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10'><?php echo $major; ?></td></tr>
<tr><th>Graduation Year:</th><td><?php echo $year; ?></td></tr>
<?php
	    }

?>
	<tr><th class='col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2'>Email:</th><td class='col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10'><?php echo $email; ?></td></tr>
</table>
<?php

    if (isset($_SESSION["sess_user_role"]) && isset($_SESSION["sess_user_id"]) && (($_SESSION["sess_user_role"] == "admin") || ($_SESSION["sess_user_id"] == $user_id)) && !(($_SESSION["sess_user_id"] != $user_id) && ($role == 'admin'))) {
        echo "<a href='/istopics/user/{$user_id}/edit' class='btn btn-warning'>Edit Profile</a>";
    }

    echo "</li>";
}
