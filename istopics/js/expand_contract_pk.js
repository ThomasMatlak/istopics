var shorten_to = 500;

/**
 * Shorten proposals
 *
 * @param int proj_id
 */
function shorten_proposal (proj_id) {
    if ($('#' + proj_id + 'full_proposal').val().length > shorten_to) {
        $('#' + proj_id + 'proposal_text').html(ellipsify($('#' + proj_id + 'full_proposal').val(), shorten_to));
        $('#' + proj_id + 'show_or_hide_p').text('show more');
    }
    $('#' + proj_id + 'show_proposal').attr('onclick', 'expand_proposal(' + proj_id + ');');
}

/**
 * Expand proposals
 *
 * @param int proj_id
 */
function expand_proposal (proj_id) {
    $('#' + proj_id + 'proposal_text').html($('#' + proj_id + 'full_proposal').val());
    $('#' + proj_id + 'show_proposal').attr('onclick', 'shorten_proposal(' + proj_id + ');');
    $('#' + proj_id + 'show_or_hide_p').text('show less');
}

/**
 * Shorten keywords
 * 
 * @param int proj_id
 */
function shorten_keywords (proj_id) {
    if ($('#' + proj_id + 'full_keywords').val().length > shorten_to) {
        $('#' + proj_id + 'keywords_text').html(ellipsify($('#' + proj_id + 'full_keywords').val(), shorten_to));
        $('#' + proj_id + 'show_or_hide_k').text('show more');
    }
    $('#' + proj_id + 'show_keywords').attr('onclick', 'expand_keywords(' + proj_id + ');');
}

/**
 * Expand keywords
 * 
 * @param int proj_id
 */
function expand_keywords (proj_id) {
    $('#' + proj_id + 'keywords_text').html($('#' + proj_id + 'full_keywords').val());
    $('#' + proj_id + 'show_keywords').attr('onclick', 'shorten_keywords(' + proj_id + ');');
    $('#' + proj_id + 'show_or_hide_k').text('show less');
}

$(document).ready(function () {
    var max_proj_id = $('#max_proj_id').val();

    projects.forEach( function(item, index, array) {
        if ($('#' + item + 'project_title').text()) {
            shorten_proposal(item);
            shorten_keywords(item);
        }
    });
});
