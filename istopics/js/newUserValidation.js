/**
 * Check that user input when making a new user profile is valid
 */

// Set all fields to default filled state
$('#check_first_name').attr("class", "has-error");
$('#check_last_name').attr("class", "has-error");
$('#discipline_check').attr("class", "has-error");
$('#year_check').attr("class", "has-warning");
$('#email_check').attr("class", "has-error");
$('#password_group').attr("class", "has-error");
$('#submit').attr("disabled", "true");

// Check that names are there
$('#first_name').on('input', function() {
    if ($('#first_name').val()) {
        $('#check_first_name').attr("class", "has-success");
    }
    else {
    	$('#check_first_name').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
    }
});
$('#last_name').on('input', function() {
    if ($('#last_name').val()) {
        $('#check_last_name').attr("class", "has-success");
    }
    else {
    	$('#check_last_name').attr("class", "has-error");
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

// Check that the graduating year is valid
$('#year').on('input', function() {
    if ($('#year').val()) {
        $('#year_check').attr("class", "has-success");
    }
    else {
    	$('#year_check').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
    }
});

// Check that the email is valid
$('#email').on('input', function() {
    if ($('#email').val()) {
        if ($('#email').val().match(/@wooster.edu/)) {
            $('#invalid_email').text('');
            $('#email_check').attr("class", "has-success");
        }
        else if (!$('#email').val().match(/@wooster.edu/)) {
            $('#invalid_email').text('You must use a *@wooster.edu email address');
            $('#email_check').attr("class", "has-error");
            $('#submit').attr("disabled", "true");
        }
    }
    else {
    	$('#email_check').attr("class", "has-error");
	    $('#submit').attr("disabled", "true");
    }
});

// Check that passwords match
$('#password').on('input', function() {
    if ($('#confirm_password').val() != $('#password').val()) {
        $('#password_not_same').text('passwords must match');
        $('#password_group').attr("class", "has-error");
        $('#submit').attr("disabled", "true");
    }
    else {
        $('#password_not_same').text('');
        if ($('#first_name').val() != "" && $('#last_name').val() != "") {
            $('#password_group').attr("class", "has-success");
        }
        else {
            $('#submit').attr("disabled", "true");
        }
    }
});
$('#confirm_password').on('input', function() {
    if ($('#confirm_password').val() != $('#password').val()) {
        $('#password_not_same').text('passwords must match');
        $('#password_group').attr("class", "has-error");
        $('#submit').attr("disabled", "true");
    }
    else {
        $('#password_not_same').text('');
        if ($('#first_name').val() != "" && $('#last_name').val() != "") {
	        $('#password_group').attr("class", "has-success");
        }
        else {
            $('#submit').attr("disabled", "true");
        }
    }
});

// Check that all fields are filled
$("form :input").on('input', function() {
    if ($('#studentSelect').is(":checked")) {
        if ($('#first_name').val() && $('#last_name').val() && ($('#discipline').val() || $('#other_discipline').val()) && $('#year').val() && $('#email').val() && $('#password').val() && $('#confirm_password').val() && ($('#password').val() == $('#confirm_password').val())) {
	        document.getElementById("submit").disabled = false;
        }
        else {
	        $('#submit').attr("disabled", "true");
        }
    }
    else if ($('#facultySelect').is(":checked")) {
        if ($('#first_name').val() && $('#last_name').val() && $('#email').val() && $('#password').val() && $('#confirm_password').val() && ($('#password').val() == $('#confirm_password').val())) {
            document.getElementById("submit").disabled = false;
        }
        else {
            $('#submit').attr("disabled", "true");
        }
    }
});

// Student/Faculty Toggle
function stud_faculty_toggle() {
    if ($('#studentSelect').is(":checked")) {
        $('#discipline_check').show();
        $('#year_check').show();
    }
    else if ($('#facultySelect').is(":checked")) {
        $('#discipline_check').hide();
        $('#year_check').hide();
    }
}
