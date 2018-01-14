/**
 * A template to use for displaying projects when filtering them
 */

function project(id, title, author, author_id, discipline, proposal, keywords, timestamp, fav_status, project_type) {
    var list_item = document.createElement("li");
    list_item.className = id;

    var panel = document.createElement("div");
    panel.className = "panel panel-default";

    var panel_heading = document.createElement("div");
    panel_heading.className = "panel-heading container-fluid";

    var t = document.createElement("a");
    t.innerHTML = title;
    t.id = id + 'project_title';
    t.className = "btn btn-link text-left col-xs-11 col-sm-11 col-md-11 col-ls-11";
    t.href = "/istopics/project/" + id;

    var f = document.createElement("form");
    f.action = "/istopics/favorite.php";
    f.method = "POST";
    f.className = "col-lg-1 col-md-1 col-sm-1 col-xs-1";

    var i1 = document.createElement("input");
    i1.type = "hidden";
    i1.name = "projectid";
    i1.value = id;
    f.appendChild(i1);

    var i2 = document.createElement("input");
    i2.type = "hidden";
    i2.name = "favorite_status";
    i2.value = (fav_status == true) ? "remove" : "add";
    f.appendChild(i2);

    var b = document.createElement("button");
    b.type = "submit";
    b.className = "btn btn-link";
    var s = document.createElement("span");
    s.className = (fav_status == true) ? "glyphicon glyphicon-star" : "glyphicon glyphicon-star-empty";
    b.appendChild(s);
    f.appendChild(b);

    panel_heading.appendChild(t);
    panel_heading.appendChild(f);
    panel.appendChild(panel_heading);

    var panel_body = document.createElement("div");
    panel_body.className = "panel-body";

    var table = document.createElement("table");
    table.className = "table";

    var caption = document.createElement("caption");
    caption.innerHTML = "<span id='" + id + "author'><a href='/istopics/user?user_id=" + author_id + "'>" + author + "</a></span></caption>";
    table.appendChild(caption);

    var caption1 = document.createElement("caption");
    if (project_type == "senior") {
        caption1.innerHTML = "Senior IS";
    }
    else if (project_type == "junior") {
        caption1.innerHTML = "Junior IS";
    }
    else if (project_type == "other") {
        caption1.innerHTML = "Other";
    }
    table.appendChild(caption1);

    var table_body = document.createElement("tbody");

    // discipline
    var discipline_row = document.createElement("tr");
    var discipline_head = document.createElement("th");
    discipline_head.className = "col-xs-1 col-sm-1 col-md-1 col-lg-1";
    discipline_head.innerHTML = "Major:";
    discipline_row.appendChild(discipline_head);
    var discipline_data = document.createElement("td");
    discipline_data.className = "col-xs-11 col-sm-11 col-md-11 col-lg-11";

    var first = true;
    var disciplines = discipline.split(', ');

    var d = "";
    for (var i = 0; i < disciplines.length; ++i) {
        if (first === true) {
            first = false
        }
        else {
            d += ", ";
        }
        d += "<a href='/istopics/project/search?discipline=" + disciplines[i] + "'>" + disciplines[i] + "</a>";
    }

    discipline_data.innerHTML = d;

    discipline_row.appendChild(discipline_data);
    table_body.appendChild(discipline_row);

    // proposal
    if (proposal != '') {
        var prop = document.createElement("tr");
        var prop_head = document.createElement("th");
        prop_head.innerHTML = "Proposal:";
        prop.appendChild(prop_head);
        var prop_data = document.createElement("td");
        prop_data.innerHTML = proposal;

        prop.appendChild(prop_data);
        table_body.appendChild(prop);
    }

    // keywords
    var key = document.createElement("tr");
    var key_head = document.createElement("th");
    key_head.innerHTML = "Keywords:";
    key.appendChild(key_head);
    var key_data = document.createElement("td");

    first = true;
    var keys = keywords.split(', ');

    var k = "";
    for (var i = 0; i < keys.length; ++i) {
        if (first === true) {
            first = false
        }
        else {
            k += ", ";
        }
        k += "<a href='/istopics/project/search?project_keywords=" + keys[i] + "'>" + keys[i] + "</a>";
    }

    key_data.innerHTML = k;
    // key_data.innerHTML = keywords;

    key.appendChild(key_data);
    table_body.appendChild(key);

    table.appendChild(table_body);
    panel_body.appendChild(table);

    var last_updated_msg = document.createElement("span");
    last_updated_msg.innerHTML = time_elapsed(timestamp);

    panel_body.appendChild(last_updated_msg);
    panel.appendChild(panel_body);
    list_item.appendChild(panel);

    return list_item;
}

/**
 * @param Date timestamp
 * @return string
 */
function time_elapsed(timestamp) {
    var now = new Date();
    var ago = new Date(timestamp);
    var diff = now - ago;

    diff /= 1000; // remove milliseconds
    var seconds = Math.round(diff % 60);
    diff = Math.floor(diff / 60);

    var minutes = Math.round(diff % 60);
    diff = Math.floor(diff / 60);

    var hours = Math.round(diff % 24);
    diff = Math.floor(diff / 24);

    var days = diff;

    var msg = "Last Updated ";
    if (days > 0) {
        msg += days + ((days > 1) ? " days" : " day");
    }
    else if (hours > 0) {
        msg += hours + ((hours > 1) ? " hours" : " hour");
    }
    else if (minutes > 0) {
        msg += minutes + ((minutes > 1) ? " minutes" : " minutes");
    }
    else if (seconds > 30) {
        msg += seconds + " seconds";
    }
    else {
        msg += "just now."
        return msg;
    }

    msg += " ago.";

    return msg;
}
