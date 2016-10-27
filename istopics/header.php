<?php
/**
 * The view to display at the top of every page
 */

if(!isset($_SESSION)) { session_start(); }

require_once 'checkSignIn.php';
require_once 'db_credentials.php';
?>

<!Doctype HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<!-- include Bootstrap style sheets -->
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  	
	<!-- custom css -->
  	<link rel="stylesheet" href="/css/istopics.css">

  	<!-- include jQuery -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  	<!-- include Bootstrap javaScript -->
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  	<link rel="icon" href="/favicon.ico">
  	<title><?php echo $page_title; ?></title>
    </head>

    <body>
        <?php include_once("analyticstracking.php") ?>

	<div class="wrapper">

	    <nav class="navbar navbar-inverse navbar-static-top">
	        <div class="container-fluid">
		    <a href='http://www.wooster.edu' class="navbar-brand">
            	        <img src='/wordmark.png' height="28" alt='The College of Wooster'/>
            	    </a>
  		    <ul class="nav nav-pills navbar-left visible-xs">
			<li><ul class="dropdown-menu">
		    <?php
        	        $role = issignedin();

			$sql = "SELECT link, visible_text, required_priveleges from header_links ORDER BY link_order ASC";
			$result = $conn->query($sql);

			while ($row = $result->fetch_assoc()) {
			    $required_role = $row['required_priveleges'];
			    $link          = $row['link'];
			    $visible_text  = $row['visible_text'];

			    if ($link == '/user') {
			        $visible_text = $visible_text. " {$_SESSION['sess_user_name']}";
			    }

			    if ($required_role == 'none') {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'signin') && ($role != -1)) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'signout') && ($role == -1)) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'student') && ($role == 'student')) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'admin') && ($role == 'admin')) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			}

			echo "</ul><button type='button' class='btn btn-link navbar-btn dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span class='glyphicon glyphicon-menu-hamburger'></span></button></li>";
    		    ?>
		    </ul>

		    <ul class="nav nav-pills navbar-left hidden-xs">
		    <?php
        	        $role = issignedin();

			$sql = "SELECT link, visible_text, required_priveleges from header_links ORDER BY link_order ASC";
			$result = $conn->query($sql);

			while ($row = $result->fetch_assoc()) {
			    $required_role = $row['required_priveleges'];
			    $link          = $row['link'];
			    $visible_text  = $row['visible_text'];

			    if ($link == '/user') {
			        if ($role != -1) {
			            $visible_text = $visible_text. " {$_SESSION['sess_user_name']}";
				}
			    }

			    if ($required_role == 'none') {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'signin') && ($role != -1)) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'signout') && ($role == -1)) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'student') && ($role == 'student')) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			    if (($required_role == 'admin') && ($role == 'admin')) {
			        echo "<li><a href='{$link}' class='btn btn-link navbar-btn'>{$visible_text}</a></li>";
			    }
			}
    		    ?>
		    </ul>

			<a href="/project/search" class="btn btn-warning navbar-btn">Advanced Search</a>

	        </div>
            </nav>

<?php
// Check for an error
if (isset($_SESSION["error"]) && $_SESSION["error"] != 0) {
   $error_msg = $_SESSION["error_msg"];
?>
   	<div class="container-fluid">
   	    <div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
			<?php echo $error_msg; ?>
	    </div>
	</div>
<?php

    unset($_SESSION["error"]);
    unset($_SESSION["error_msg"]);
}

// Check for a message
if (isset($_SESSION["message"]) && $_SESSION["message"] == 1) {
   $msg = $_SESSION["msg"];
?>
   	<div class="container-fluid">
   	    <div class="alert alert-success alert-dismissible" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
	        <?php echo $msg; ?>
	    </div>
	</div>
<?php

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
if (isset($_SESSION["message"]) && $_SESSION["message"] == 2) {
   $msg = $_SESSION["msg"];
?>
   	<div class="container-fluid">
   	    <div class="alert alert-info alert-dismissible" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
                <?php echo $msg; ?>
	    </div>
	</div>
<?php

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
if (isset($_SESSION["message"]) && $_SESSION["message"] == 3) {
   $msg = $_SESSION["msg"];
?>
   	<div class="container-fluid">
   	    <div class="alert alert-warning alert-dismissible" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
	        <?php echo $msg; ?>
	    </div>
	</div>
<?php

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
?>

<div class="container-fluid">