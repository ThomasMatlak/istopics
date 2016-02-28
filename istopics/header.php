<?php
session_start();
?>

<!Doctype HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- include Bootstrap style sheets -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- include jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <!-- include Bootstrap javaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  <title><?php echo $page_title; ?></title>
  <link rel="icon" href="favicon.ico">

</head>

<body>

<nav class="navbar navbar-inverse navbar-static-top col-lg-12 col-md-12 col-sm-12 col-sx-12">
<div class="container-fluid">
  <a href="showAllProjects.php" class="navbar-brand">Home</a>
  <ul class="nav nav-pills navbar-left">
    <li><a href="showAllProjects.php" class="btn btn-link navbar-btn">View All Projects</a></li>
    <li><a href="newProject.php" class="btn btn-link navbar-btn">Add a New Project</a></li>
   
    <?php
       if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
           //user is signed in
	   echo <<<EOT
	   
           <li><p class='navbar-text'>Hello {$_SESSION["sess_user_name"]}</p></li>
	   <li><a href='logout.php' class='nav btn btn-link navbar-btn'>Sign Out</a></li>
	   </ul>
EOT;
       }
       else {
           //user is not signed in
	   echo <<<EOT
	   
           <li><a href='login.php' class='nav btn btn-link navbar-btn'>Sign In</a></li>
           <li><a href='newUser.php' class='nav btn btn-link navbar-btn'>New User?</a></li>
	   </ul>
EOT;
       }
    ?>
<div class="nav navbar-right">
    <noscript>
    <form id="search" action="search.php" method="GET" class="navbar-form">
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
	     <p>
		{$error_msg}
	     </p>
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
   	<div class="alert alert-success" role="alert">
	     <p>
		{$msg}
	     </p>
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
   	<div class="alert alert-info" role="alert">
	     <p>
		{$msg}
	     </p>
	</div>
	</div>
EOT;

    unset($_SESSION["message"]);
    unset($_SESSION["msg"]);
}
?>