/**
 * Provide auto-complete functionality for searching through projects
 *
 * Currently only provides suggestions for the keywords field
 */

$(document).ready(function() {
    var availableTerms = $('#all_keywords').val().split(","); // the terms to suggest

    function split( val ) {
      	return val.split( /,\s*/ );
    }
    function extractLast( term ) {
		return split( term ).pop();
    }
 
    $( "#search" )
        // don't navigate away from the field on tab when selecting an item
	.bind( "keydown", function( event ) {
		if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
			event.preventDefault();
		}
	})
	.autocomplete({
		minLength: 0,
		source: function( request, response ) {
			// delegate back to autocomplete, but extract the last term
			response( $.ui.autocomplete.filter(
			availableTerms, extractLast( request.term ) ) );
		},
		focus: function() {
			// prevent value inserted on focus
			return false;
		},
		select: function( event, ui ) {
			var terms = split( this.value );
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// add placeholder to get the comma-and-space at the end
			terms.push( "" );
			this.value = terms.join( ", " );

			search_all();
			return false;
		}
    });
});
