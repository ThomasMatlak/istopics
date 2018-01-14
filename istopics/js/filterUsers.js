/**
 * Filter and sort projects based on the input box
 */

$("form :input").on('input', function() {
    search_users();
});

/**
 * 
 */
function search_users() {
    var searchTerms = $('#search').val().toLowerCase().split(",");

    // Start by hiding all users
    u.users.forEach(function(item, index, array) {
        $('.'+item.id).remove();
    });

    if (!$('#search').val()) {
        // Input is empty; display all projects
        u.users.forEach( function(item, index, array) {
            // display users
            if (item.role === 'student') {
                $('#users_list').append(user(item.id, item.first_name, item.last_name, item.role, item.major, item.year, item.email));
            }
            else {
                $('#users_list').append(user(item.id, item.first_name, item.last_name, item.role, false, false, item.email));
            }
        });
    }
    else {
        u.users.forEach(function(item, index, array) {
            item.score = 0;

            var first_name = item.first_name.toLowerCase();
            var last_name = item.last_name.toLowerCase();
            var role = item.role.toLowerCase();
            var major = item.major.toLowerCase();
            var year = item.year;
            var email = item.email.toLowerCase();

            for (j = 0; j < searchTerms.length; ++j) {
                var searchTerm = searchTerms[j].trim().replace(",", "").toLowerCase();
                var matched = false; // user must match all search terms

                if (searchTerm === "") {break;}

                if (first_name.search(searchTerm) != -1) {
                    item.score += 5;
                    matched = true;
                }
                if (last_name.search(searchTerm) != -1) {
                    item.score += 5;
                    matched = true;
                }
                if ((first_name + " " + last_name).search(searchTerm) != -1) {
                    item.score += 10;
                    matched = true;
                }
                if (role.search(searchTerm) != -1) {
                    item.score += 1;
                    matched = true;
                }
                if (major.search(searchTerm) != -1) {
                    item.score += 1;
                    matched = true;
                }
                if (year.search(searchTerm) != -1) {
                    item.score += 1;
                    matched = true;
                }
                if (email.search(searchTerm) != -1) {
                    item.score += 10;
                    matched = true;
                }

                if (matched !== true) {
                    item.score = 0;
                    break;
                }
            }
        });

        // sort users
        u.users.sort(function(a,b) {
            return parseFloat(b.score) - parseFloat(a.score);
        });

        u.users.forEach(function(item, index, array) {
            if (item.score > 0) {
                if (item.role === 'student') {
                $('#users_list').append(user(item.id, item.first_name, item.last_name, item.role, item.major, item.year, item.email));
                }
                else {
                    $('#users_list').append(user(item.id, item.first_name, item.last_name, item.role, false, false, item.email));
                }
            }
        });
    }
}
