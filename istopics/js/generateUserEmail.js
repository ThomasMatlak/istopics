/**
 *  Auto fill the user's email as they enter their information during registration
 * 
 * @deprecated
 */

$("form :input").on('input', function() {
    var first_name = $('#first_name').val();
    var first_name_letter = first_name.charAt(0).toLowerCase();

    var last_name = $('#last_name').val().toLowerCase();

    var year = $('#year').val().substring(2,4);

    var email = first_name_letter + last_name + year + "@wooster.edu";

    $('#email').val(email);
});
