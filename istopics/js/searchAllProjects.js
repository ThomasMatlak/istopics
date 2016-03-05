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
    }
    else {
	// Input is not empty; search for and display projects matching search terms
	for (i = 0; i <= max_proj_id; i++) {
	    var keywords = $('#'+i+'keywords').text().toLowerCase();
	    var title = $('#'+i+' li button strong').text().toLowerCase();

	    if ((keywords.search(searchTerm) != -1) || (title.search(searchTerm) != -1)) {
		// Some keywords or words in the title match the search term; display the project
		$('#'+i).show();
	    }
	}
    }
});
