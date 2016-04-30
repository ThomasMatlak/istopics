<?php
/*
* header.php
*
* The view to display at the top of every page
*/

if(!isset($_SESSION)) { session_start(); }

require_once 'checkSignIn.php';
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
		    <!--<a href="/project/all" class="navbar-brand">Home</a>-->
		    <a href='http://www.wooster.edu' class="navbar-brand">
            	        <img src='/wordmark.png' height="28" alt='The College of Wooster'/>
            	    </a>
  		    <ul class="nav nav-pills navbar-left visible-xs">
			<li><ul class="dropdown-menu">
			<li><a href="/project/all" class="btn btn-link navbar-btn">View All Projects</a></li>
   
		    <?php
        	        $role = issignedin();

        		if (issignedin() != -1) {
            		    // user is signed in
	    		    if ($role == "student") {
	       		        // user is a student
	       			echo "<li><a href='/project/new' class='btn btn-link navbar-btn'>Add a New Project</a></li>";
	   		    }
	   		echo <<<EOT
	       		    <li><a href='/user' class='btn btn-link navbar-btn'>Hello {$_SESSION['sess_user_name']}</a></li>
	       		    <li><a href='/logout.php' class='nav btn btn-link navbar-btn'>Sign Out</a></li>
EOT;
			    if ($role == "admin") {
	   		        // user is an admin
	   			echo "<li><a href='/admin' class='btn btn-link navbar-btn'>Administrator Interface</a></li>";
			    }
			    echo '</ul><button type="button" class="btn btn-link navbar-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button></ul>';
                    	}
       			else {
           		    // user is not signed in
	   		    echo <<<EOT
           		        <li><a href='/signin' class='nav btn btn-link navbar-btn'>Sign In</a></li>
           			<li><a href='/register' class='nav btn btn-link navbar-btn'>New User?</a></li>
	   			</ul>
				<button type="button" class="btn btn-link navbar-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
				</ul>
EOT;
			}
    		    ?>

		    <ul class="nav nav-pills navbar-left hidden-xs">
    		        <li><a href="/project/all" class="btn btn-link navbar-btn">View All Projects</a></li>
   
		    <?php
        	        $role = issignedin();

        		if (issignedin() != -1) {
            		    // user is signed in
	    		    if ($role == "student") {
	       		        // user is a student
	       			echo "<li><a href='/project/new' class='btn btn-link navbar-btn'>Add a New Project</a></li>";
	   		    }
	   		echo <<<EOT
	       		    <li><a href='/user' class='btn btn-link navbar-btn'>Hello {$_SESSION['sess_user_name']}</a></li>
	       		    <li><a href='/logout.php' class='nav btn btn-link navbar-btn'>Sign Out</a></li>
EOT;
			    if ($role == "admin") {
	   		        // user is an admin
	   			echo "<li><a href='/admin' class='btn btn-link navbar-btn'>Administrator Interface</a></li>";
			    }
			    echo "</ul>";
                    	}
       			else {
           		    // user is not signed in
	   		    echo <<<EOT
           		        <li><a href='/signin' class='nav btn btn-link navbar-btn'>Sign In</a></li>
           			<li><a href='/register' class='nav btn btn-link navbar-btn'>New User?</a></li>
	   			</ul>
EOT;
			}
    		    ?>

		    <!-- Header logo file -->
        	    <!--<ul class='nav navbar-nav navbar-right'>
			<li>
            		    <a href='http://www.wooster.edu'>
            		        <img src='/wordmark.png' height="28" alt='The College of Wooster'/>
            		    </a>
			</li>
		    </ul>-->

		    <noscript>
		        <form id="search_html" action="/project/search" method="GET" class="navbar-form">
                            <div class="form-group">
	                        <input type="text" class="form-control" name="search_term" id="search_term" placeholder="search">
				<button type="submit" class="btn btn-warning">Search</button>
                            </div>
			</form>
                    </noscript>

	        </div>
            </nav>

<?php
// Check for an error
if (isset($_SESSION["error"]) && $_SESSION["error"] != 0) {
   $error_msg = $_SESSION["error_msg"];
   echo <<<EOT
   	<div class="container-fluid">
   	    <div class="alert alert-danger" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
		{$error_msg}
	    </div>
	</div>
EOT;

    unset($_SESSION["error"]);
    unset($_SESSION["error_msg"]);
}

// Check for a message
if (isset($_SESSION["message"]) && $_SESSION["message"] == 1) {
   $msg = $_SESSION["msg"];
   echo <<<EOT
   	<div class="container-fluid">
   	    <div class="alert alert-success alert-dismissible" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
	        {$msg}
	    </div>
	</div>
EOT;

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
if (isset($_SESSION["message"]) && $_SESSION["message"] == 2) {
   $msg = $_SESSION["msg"];
   echo <<<EOT
   	<div class="container-fluid">
   	    <div class="alert alert-info alert-dismissible" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
                {$msg}
	    </div>
	</div>
EOT;

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
if (isset($_SESSION["message"]) && $_SESSION["message"] == 3) {
   $msg = $_SESSION["msg"];
   echo <<<EOT
   	<div class="container-fluid">
   	    <div class="alert alert-warning alert-dismissible" role="alert">
	    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class='glyphicon glyphicon-remove' aria-hidden="true"></span></button>
	        {$msg}
	    </div>
	</div>
EOT;

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
?>

<div class="container-fluid">