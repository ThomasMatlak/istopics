// Set all fields to default filled state
$('#check_first_name').attr("class", "has-success");
$('#check_last_name').attr("class", "has-success");
$('#discipline_check').attr("class", "has-error");
$('#year_check').attr("class", "has-success");
$('#email_check').attr("class", "has-success");
document.getElementById("submit").disabled = false;

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
    if ($('#discipline').val()) {
        $('#stud_major').text($('#discipline').val());
	$('#discipline_check').attr("class", "has-success");
    }
    else {
    	$('#stud_major').text('');
    	$('#discipline_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
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
//VALIDATE EMAIL
    if ($('#email').val()) {
        $('#email_check').attr("class", "has-success");
    }
    else {
    	$('#email_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

// Check that all fields are filled
$("form :input").on('input', function() {
    if ($('#first_name').val() && $('#last_name').val() && $('#discipline').val() && $('#year').val() && $('#email').val()) {
       document.getElementById("submit").disabled = false;
    }
});
