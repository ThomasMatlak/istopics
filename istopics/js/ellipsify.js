/**
 * Shorten a string to shorten_to characters before adding an ellipsis
 *
 * str        - the string to shorten
 * shorten_to - how short to make str
 */

function ellipsify (str, shorten_to) {
    if (str.length < shorten_to) {
	    return str;
    }
    else {
	    return str.substring(0, shorten_to) + "&hellip;";
    }
}
