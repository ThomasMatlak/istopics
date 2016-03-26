// Search all projects based on keywords or title content
$("form :input").on('input', function() {
    var searchTerms = $('#search').val().toLowerCase().split(",");

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
	$('#no_results_msg').text('');
	$('#num_projects').text($('#initial_num_results').val());
	if (num_projects == 1) { $('#result_or_results').text('result'); }
 	else { $('#result_or_results').text('results'); }
    }
    else {
        // Keep track of how many projects are being shown
        var num_projects = 0;

	// Input is not empty; search for and display projects matching search terms
	//for (j = 0; j < searchTerms.length; j++) {
	for (i = 0; i <= max_proj_id; i++) {
	    project_showed = false;

	    //for (i = 0; i <= max_proj_id; i++) {
	    for (j = 0; j < searchTerms.length; j++) {
		var searchTerm = searchTerms[j].trim();

		var keywords = $('#'+i+'keywords').text().toLowerCase();
		var title = $('#'+i+'project_title').text().toLowerCase();
		var major = $('#'+i+'project_major').text().toLowerCase();
		var proposal = $('#'+i+'proposal').text().toLowerCase();
		var name = $('#'+i+'author').text().toLowerCase();

		// Search term is empty -- there is nothing after the comma in the search terms
		if (searchTerm == "") { break; }

		if ((keywords.search(searchTerm) != -1) || (title.search(searchTerm) != -1) || (major.search(searchTerm) != -1) || (proposal.search(searchTerm) != -1) || (name.search(searchTerm) != -1)) {
		    // Some keywords or words in the title match the search term; display the project
		    $('#'+i).show();
		    var project_showed = true;
		}
	    }
	    if (project_showed == true) { num_projects++; }
	}
	$('#num_projects').text(num_projects);
	$('#no_results_msg').text('');
	if (num_projects == 0) { $('#no_results_msg').text('No results were found. Try different keywords'); }
	else if (num_projects == 1) { $('#result_or_results').text('result'); }
	else { $('#result_or_results').text('results'); }
    }
});
