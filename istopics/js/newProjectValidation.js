//Set all fields to default filled state
$('#check_title').attr("class", "has-error");
$('#discipline_check').attr("class", "has-error");
$('#submit').attr("disabled", "true");

//Check that the title is there
$('#title').on('input', function() {
    if ($('#title').val()) {
        $('#check_title').attr("class", "has-success");
    }
    else {
    	$('#check_title').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Display the user's selection of major(s)
$('#discipline').on('input', function() {
    if ($('#discipline').val()) {
        $('#proj_disc').text($('#discipline').val());
	$('#discipline_check').attr("class", "has-success");
    }
    else {
    	$('#proj_disc').text('');
    	$('#discipline_check').attr("class", "has-error");
	$('#submit').attr("disabled", "true");
    }
});

//Check that all required fields are filled
$("form :input").on('input', function() {
    if ($('#title').val() && $('#discipline').val()) {
       document.getElementById("submit").disabled = false;
    }
});