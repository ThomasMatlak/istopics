/*
* Shorten a string to shorten_to characters before adding an ellipsis
* set shorten_to = the length you want to shorten string to
*/

function ellipsify (str, shorten_to) {
    if (str.length < shorten_to) {
	return str;
    }
    else {
	return str.substring(0, shorten_to) + "&hellip;";
    }
}
