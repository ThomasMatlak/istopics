function resetWarning() {
    if (confirm("Are you sure you want to reset the database?\nThis change is permenant.")) {
	$.get('resetDatabase.php', function(data) {
	    eval(data);
	});
    }
    else {
	// Do nothing
    }
}
