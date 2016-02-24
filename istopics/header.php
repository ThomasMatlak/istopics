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

<nav class="navbar navbar-inverse navbar-static-top">
<div class="container-fluid">
  <a href="showAllProjects.php" class="navbar-brand">Home</a>
  <ul class="nav nav-pills navbar-left">
    <li><a href="showAllProjects.php" class="navbar-link">View All Projects</a></li>
    <li><a href="newProject.php" class="navbar-link">Add a New Project</a></li>
  </ul>
  <ul class="nav navbar-right">
    <?php
       if (isset($_SESSION["sess_user_id"]) && isset($_SESSION["sess_user_name"])) {
           //user is signed in
           echo "<p class='navbar-text'>Hello ". $_SESSION["sess_user_name"]. "</p>";
	   echo "<a href='logout.php' class='nav btn btn-link navbar-btn'>Sign Out</a>";
       }
       else {
           //user is not signed in
           echo "<a href='login.php' class='nav btn btn-link navbar-btn'>Sign In</a>";
           echo "<a href='newUser.php' class='nav btn btn-link navbar-btn'>New User?</a>";
       }
    ?>
    
    <form id="search" action="search.php" method="GET" class="navbar-form navbar-right">
      <div class="form-group">
	<input type="text" class="form-control" name="search_term" id="search_term" placeholder="search">
	<button type="submit" class="btn">Search</button>
      </div>
    </form>
  </ul>
</div>
</nav>
