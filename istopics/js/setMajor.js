// Set the major in the select multiple input
$(document).ready(function () {
    if (document.getElementById('discipline') == null) { return 0; }

    var majors = document.getElementById('discipline').options;

    var student_majors = [];

    var st_majors = $('#st_major').val().split(", ");

    for (i = 0; i < majors.length; i++) {
	for (j = 0; j < st_majors.length; j++) {
	    if (st_majors[j] == majors[i].value) {
		student_majors.push(majors[i].value);
		$('#discipline_check').attr("class", "has-success");
	    }
	}
    }

    $('#discipline').val(student_majors);
    $('#stud_major').text($('#discipline').val());
});
