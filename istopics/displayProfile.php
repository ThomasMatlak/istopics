<?php
/*
* displayProfile.php
*
* Provides a function to output a profile list item
*
* To use this function, place
*     require_once 'displayProfile.php';
* before calling display_profile()
*/

function display_profile($user_id, $name, $show_name, $major, $year, $email, $role) {
/*
* user_id    - the id of the user being displayed
* name      - the uses's name
* show_name - show the user's name? (T/F)
* major     - the user's major, if they are a student
* year      - the user's class year, if they are a student
* email     - the user's email
* role      - the user's role
*/

    echo <<<EOT
        <li>
	    <table class='table'>
EOT;
	    if ($role == "student") {
	        echo <<<EOT
	            <tr><th class='col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2'>Major(s):</th><td class='col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10'>{$major}</td></tr>
		    <tr><th>Graduation Year:</th><td>{$year}</td></tr>
EOT;
	    }


    echo <<<EOT
	        <tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Email:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'>{$email}</td></tr>
	    </table>
	</li>
EOT;


    if (isset($_SESSION["sess_user_role"]) && isset($_SESSION["sess_user_id"]) && ($_SESSION["sess_user_role"] == "admin") || ($_SESSION["sess_user_id"] == $user_id)) {
        echo <<<EOT
 
       	    <form action='/user/edit' method='GET'>
	        <input type='hidden' name='user_id' id='user_id' value='{$user_id}'>
	        <button class='btn btn-warning'>Edit Profile</button>
	    </form>
EOT;
    }
}

?>