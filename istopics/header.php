<?php
/*
* header.php
*
* The view to display at the top of every page
*/

session_start();
?>

<!Doctype HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- include Bootstrap style sheets -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- custom css -->
  <link rel="stylesheet" href="css/istopics.css">

  <!-- include jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <!-- include Bootstrap javaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  <link rel="icon" href="favicon.ico">
  <title><?php echo $page_title; ?></title>

</head>

<body>
<?php include_once("analyticstracking.php") ?>

<div class="wrapper">

<nav class="navbar navbar-inverse navbar-static-top">
<div class="container-fluid">
  <a href="showAllProjects.php" class="navbar-brand">Home</a>
  <ul class="nav nav-pills navbar-left">
    <li><a href="showAllProjects.php" class="btn btn-link navbar-btn">View All Projects</a></li>
   
    <?php
       if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"]) && isset($_SESSION["sess_user_role"])) {
           // user is signed in
	   if ($_SESSION["sess_user_role"] == "student") {
	       // user is a student
	       echo "<li><a href='newProject.php' class='btn btn-link navbar-btn'>Add a New Project</a></li>";
	   }
	   echo <<<EOT
	       <li><a href='viewProfile.php' class='btn btn-link navbar-btn'>Hello {$_SESSION['sess_user_name']}</a></li>
	       <li><a href='logout.php' class='nav btn btn-link navbar-btn'>Sign Out</a></li>
EOT;
	if ($_SESSION["sess_user_role"] == "admin") {
	   // user is an admin
	   echo "<li><a href='adminInterface.php' class='btn btn-link navbar-btn'>Administrator Interface</a></li>";
	}
	echo "</ul>";
       }
       else {
           // user is not signed in
	   echo <<<EOT
           <li><a href='login.php' class='nav btn btn-link navbar-btn'>Sign In</a></li>
           <li><a href='newUser.php' class='nav btn btn-link navbar-btn'>New User?</a></li>
	   </ul>
EOT;
       }
    ?>
<div class="nav navbar-right">
    <noscript>
    <form id="search_html" action="search.php" method="GET" class="navbar-form">
      <div class="form-group">
	<input type="text" class="form-control" name="search_term" id="search_term" placeholder="search">
	<button type="submit" class="btn btn-warning">Search</button>
      </div>
    </form>
    </noscript>
 </div>
</div>
</nav>

<?php
//Check for an error
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

//Check for a message
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