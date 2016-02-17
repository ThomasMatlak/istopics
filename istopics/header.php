<!Doctype HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- include Bootstrap style sheets -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- include jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <title><?php echo $page_title; ?></title>
  
</head>

<body>

<nav class="navbar navbar-inverse navbar-static-top">
<div class="container-fluid">
  <a href="showAllProjects.php" class="navbar-brand">Home</a>
  <ul class="nav nav-pills navbar-left">
    <li><a href="showAllProjects.php">View All Projects</a></li>
    <li><a href="newProject.php">Add a New Project</a></li>
  </ul>
  <form id="search" action="search.php" method="GET" class="navbar-form navbar-right">
    <div class="form-group">
      <input type="text" class="form-control" name="search_term" id="search_term" placeholder="search">
      <button type="submit" class="btn">Search</button>
    </div>
  </form>
</div>
</nav>
