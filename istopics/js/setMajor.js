// Set the major in the select multiple input
$(document).ready(function() {
    if (document.getElementById('discipline') == null) { return 0; }

    var majors = document.getElementById('discipline').options;

    var student_majors = [];

    var st_major = $('#st_major').val();
    
    for (i = 0; i < majors.length; i++) {
	if ($('#st_major').val().indexOf(majors[i].value) != -1) {
	    student_majors.push(majors[i].value);
	    $('#discipline_check').attr("class", "has-success");
	}
    }
    
    $('#discipline').val(student_majors);
    $('#stud_major').text($('#discipline').val());
});
