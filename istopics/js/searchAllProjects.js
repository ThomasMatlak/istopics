// Search all projects based on keywords or title content
$("form :input").on('input', function() {
    var searchTerm = $('#search').val().toLowerCase();

    var max_proj_id = $('#max_proj_id').val();

    // Hide everything by default
    for (i = 0; i <= max_proj_id; i++) {
	$('#'+i).hide();
    }

    if (!$('#search').val()) {
	// Input is empty; display all projects
	for (i = 0; i <= max_proj_id; i++) {
	    $('#'+i).show();
	}
	$('#num_projects').text($('#initial_num_results').val());
	if (num_projects == 1) { $('#result_or_results').text('result') }
 	else { $('#result_or_results').text('results') }
    }
    else {
        // Keep track of how many projects are being shown
        var num_projects = 0;

	// Input is not empty; search for and display projects matching search terms
	for (i = 0; i <= max_proj_id; i++) {
	    var keywords = $('#'+i+'keywords').text().toLowerCase();
	    var title = $('#'+i+'project_title').text().toLowerCase();
	    var major = $('#'+i+'project_major').text().toLowerCase();
	    var proposal = $('#'+i+'proposal').text().toLowerCase();
	    var name = $('#'+i+'author').text().toLowerCase();

	    if ((keywords.search(searchTerm) != -1) || (title.search(searchTerm) != -1) || (major.search(searchTerm) != -1) || (proposal.search(searchTerm) != -1) || (name.search(searchTerm) != -1)) {
		// Some keywords or words in the title match the search term; display the project
		$('#'+i).show();

		num_projects++;
	    }
	}
	$('#num_projects').text(num_projects);
	if (num_projects == 1) { $('#result_or_results').text('result') }
	else { $('#result_or_results').text('results') }
    }
});
