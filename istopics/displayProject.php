<?php
/*
* displayProject.php
*
* Provides a function to output a project list item
*
* To use this function, place
*     require_once 'displayProject.php';
* before calling display_project()
*/

function display_project($proj_id, $proj_author, $author_id, $proj_title, $proj_discipline, $proj_proposal, $proj_keywords, $proj_comments, $show_comments, $show_author) {
/*
* proj_id         - the id of the project being displayed
* proj_author     - the name of the author of the project
* author_id       - the id of the author of the project
* proj_title      - the title of the project
* proj_discipline - the project's discipline/major
* proj_proposal   - the project's proposal
* proj_keywords   - the project's keywords
* proj_comments   - the project's comments
* show_comments   - do you want to show the project's comments (true/false)
* show_author     - do you want to show the project's author (true/false)
*
* Note that there must be a list opening tag preceding the use of this function in order to display correctly 
*/

    echo <<<EOT
    	<li>
	    <div id="{$proj_id}" class="panel panel-default">
	        <div class="panel-heading">
                    <form action='viewProject.php' method='GET' class='form-inline'>
		        <input type='hidden' name='project_id' value='{$proj_id}'>
			<button type='submit' class='btn btn-link'><span id="{$proj_id}project_title">{$proj_title}</span></button>
		    </form>
	        </div> <!-- panel heading -->
	        <div class="panel-body">
	            <table class='table'>
EOT;

	if ($show_author == true) {
	    echo "<caption><span id='{$proj_id}author'><a href='viewProfile.php?user_id={$author_id}'>{$proj_author}</a></span></caption>";
	}

	echo "<tr><th class='col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1'>Major:</th><td class='col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11'><div id='{$proj_id}project_major'>{$proj_discipline}</div></td></tr>";

	if ($proj_proposal != NULL) {
	   echo <<<EOT
	       <tr><th>Proposal:</th><td><div id='{$proj_id}proposal'><span id='{$proj_id}proposal_text'>{$proj_proposal}</span><a id='{$proj_id}show_proposal' role='button' onclick='expand_proposal({$proj_id});'> <span id='{$proj_id}show_or_hide_p'></span></a></div></td></tr>
EOT;
	}

	if ($show_comments == true) {
	    echo "<tr><th>Comments:</th><td>{$proj_comments}</td></tr>";
	}

	if ($proj_keywords != NULL) {
	   echo <<<EOT
	       <tr><th>Keywords:</th><td><div id='{$proj_id}keywords'><span id='{$proj_id}keywords_text'>{$proj_keywords}</span><a id='{$proj_id}show_keywords' role='button' onclick='expand_keywords({$proj_id});'> <span id='{$proj_id}show_or_hide_k'></span></a></div></td></tr>
EOT;
	}
	echo <<<EOT
	            </table>
		    <input type='hidden' id='{$proj_id}full_proposal' value='{$proj_proposal}'>
		    <input type='hidden' id='{$proj_id}full_keywords' value='{$proj_keywords}'>
	        </div> <!-- panel body -->
	    </div> <!-- panel -->
	</li>
EOT;
}

?>