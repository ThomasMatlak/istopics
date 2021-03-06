/**
 * Check that user input when creating a project is valid
 */

// Set all fields to default filled state
$('#check_title').attr("class", "has-error");
$('#discipline_check').attr("class", "has-error");
$('#check_keywords').attr("class", "has-error");
$('#submit').attr("disabled", "true");

// Check that the title is there
$('#title').on('input', function() {
    if ($('#title').val()) {
        $('#check_title').attr("class", "has-success");
    }
    else {
    	$('#check_title').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
    }
});

// Display the user's selection of major(s)
$('#discipline').on('input', function() {
    if ($('#discipline').val() && !$('#other_discipline').val()) {
        $('#stud_major').text($('#discipline').val());
	    $('#discipline_check').attr("class", "has-success");
    }
    else if (!$('#other_discipline').val()) {
    	$('#stud_major').text('');
    	$('#discipline_check').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
    }
    else {
        $('#stud_major').text($('#other_discipline').val());
    }
});

$('#other_discipline').on('input', function() {
    if ($('#other_discipline').val()) {
        $('#stud_major').text($('#other_discipline').val());
	    $('#discipline_check').attr("class", "has-success");
        $('#discipline').attr("disabled", "true");
    }
    else if (!$('#discipline').val()) {
        $('#stud_major').text('');
    	$('#discipline_check').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
        document.getElementById("discipline").disabled = false;
    }
    else {
        $('#stud_major').text($('#discipline').val());
        document.getElementById("discipline").disabled = false;
    }
});

// Check that the user has input keywords
$('#keywords').on('input', function() {
    if ($('#keywords').val()) {
        $('#check_keywords').attr("class", "has-success");
    }
    else {
    	$('#check_keywords').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
    }
});

// Check that all required fields are filled
$("form :input").on('input', function() {
    if ($('#title').val() && ($('#discipline').val() || $('#other_discipline').val()) && $('#keywords').val()) {
	    document.getElementById("submit").disabled = false;
    }
    else {
	    $('#submit').attr("disabled", "true");
    }
});
