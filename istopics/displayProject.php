<?php
/**
 * Provides a function to output a project list item
 *
 * To use this function, place
 *     require_once 'displayProject.php';
 * before calling display_project()
 */

//require_once 'db_credentials.php';
require_once 'timeElapsed.php';
require_once 'checkSignIn.php';

function display_project($proj_id, $proj_author, $author_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, $proj_comments, $last_updated, $show_comments, $show_author, $conn) {
/**
 * @param int    $proj_id         - the id of the project being displayed
 * @param string $proj_author     - the name of the author of the project
 * @param int    $author_id       - the id of the author of the project
 * @param string $proj_title      - the title of the project
 * @param string $proj_discipline - the project's discipline/major
 * @param string $proj_proposal   - the project's proposal
 * @param string $proj_keywords   - the project's keywords
 * @param string $proj_comments   - the project's comments
 * @param string $last_updated    - when the project was last updated
 * @param bool   $show_comments   - do you want to show the project's comments (true/false)
 * @param bool   $show_author     - do you want to show the project's author (true/false)
 *
 * Note that there must be a list opening tag preceding the use of this function in order to display correctly 
 */

?>
<li class="<?php echo $proj_id; ?>">
<div class="panel panel-default">
	<div class="panel-heading container-fluid">
		<a href="/project?project_id=<?php echo $proj_id; ?>" id="<?php echo $proj_id; ?>project_title" class="btn btn-link text-left col-xs-11 col-sm-11 col-md-11 col-ls-11"><?php echo $proj_title; ?></a>
<?php
		    if (issignedin() != -1) {
		        echo "<form action='/favorite.php' method='POST' class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>";
				echo "<input type='hidden' name='projectid' value='{$proj_id}'>";

				$userid = $_SESSION['sess_user_id'];
				$sql = "SELECT userid, projectid FROM user_project_favorites WHERE projectid={$proj_id} AND userid={$userid}";

				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// user has already favorited the project, present the removal option
					echo "<input type='hidden' name='favorite_status' value='remove'>";
					echo "<button type='submit' class='btn btn-link'><span class='glyphicon glyphicon-star'></span></button>";
				}
				else {
					// user has not yet favorited the project, present the add option
					echo "<input type='hidden' name='favorite_status' value='add'>";
					echo "<button type='submit' class='btn btn-link'><span class='glyphicon glyphicon-star-empty'></span></button>";
				}
				
				echo "</form>";
		    }
?>
</div> <!-- panel heading -->
<div class="panel-body">
	<table class='table'>
<?php

	if ($show_author == true) {
	    echo "<caption><span id='{$proj_id}author'><a href='/user?user_id={$author_id}'>{$proj_author}</a></span></caption>";
	}

	echo "<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Major:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'><div id='{$proj_id}project_major'>{$proj_discipline}</div></td></tr>";

	if ($proj_proposal != NULL) {
		echo "<tr><th>Proposal:</th><td><div id='{$proj_id}proposal'><span id='{$proj_id}proposal_text'>{$proj_proposal}</span><a id='{$proj_id}show_proposal' role='button' onclick='expand_proposal({$proj_id});'> <span id='{$proj_id}show_or_hide_p'></span></a></div></td></tr>";
	}

	if ($show_comments == true && $proj_comments != NULL) {
	    echo "<tr><th>Comments:</th><td>{$proj_comments}</td></tr>";
	}

	if ($proj_keywords != NULL) {
	       echo "<tr><th>Keywords:</th><td><div id='{$proj_id}keywords'><span id='{$proj_id}keywords_text'>{$proj_keywords}</span><a id='{$proj_id}show_keywords' role='button' onclick='expand_keywords({$proj_id});'> <span id='{$proj_id}show_or_hide_k'></span></a></div></td></tr>";
	}

	$updated_x_ago = time_elapsed($last_updated);

?>
			</table>
		Last Updated <?php echo $updated_x_ago; ?>
		<input type='hidden' id='<?php echo $proj_id; ?>full_proposal' value='<?php echo $proj_proposal; ?>'>
		<input type='hidden' id='<?php echo $proj_id; ?>full_keywords' value='<?php echo $proj_keywords; ?>'>
		</div> <!-- panel body -->
	</div> <!-- panel -->
</li>
<?php
}
