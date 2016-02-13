<?php
$page_title = "Add a New Project";
include("header.php");
?>

<div class="container-fluid">
<form id="new_project" action="newProjectController.php" method="POST" class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <label for="title" class="control-label">Title:</label>
    <input type="text" name="title" id="title" class="form-control">
    <label for="discipline" class="control-label">Discipline:</label>
    <?php include("majors.html"); ?>
    <!--<input type="text" name="discipline" id="discipline" class="form-control">-->
    <label for="abstract" class="control-label">Abstract:</label>
    <textarea rows="5" cols="80" name="abstract" form="new_project" id="abstract" class="form-control"></textarea>
    <label for="keywords" class="control-label">Keywords:</label>
    <textarea rows="1" cols="80" name="keywords" form="new_project" id="keywords" class="form-control"></textarea>
    <label for="comments" class="control-label">Additional Comments:</label>
    <textarea rows="2" cols="80" name="comments" form="new_project" id="comments" class="form-control"></textarea>
    <button type="submit" class="btn btn-warning form-control">Submit</button>
  </div>
</form>
</div>

<?php 
include("footer.php")
?>