// Set the major in the select multiple input
$(document).ready(function() {
    var majors = document.getElementById('discipline').options;

    var student_majors = [];

    for (i = 0; i < majors.length; i++) {
	if ($('#st_major').val().search(majors[i].value) != -1) {
	    //$('#discipline.val("' + majors[i].value + '")').attr('selected', true);
	    student_majors.push(majors[i].value);
	    $('#discipline_check').attr("class", "has-success");
	}
    }
    $('#discipline').val(student_majors);
    $('#stud_major').text($('#discipline').val());
});
