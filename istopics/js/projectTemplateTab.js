function project(id, title, author, author_id, discipline, proposal, keywords, timestamp, fav_status, project_type) {
    var table_item = document.createElement("tr");
    table_item.className = id;

    var t = document.createElement("td");
    t.innerHTML = '<a href="' + '/istopics/project/' + id + '">' + title + '</a>';
    t.id = id + 'project_title';
    table_item.appendChild(t);

    var a = document.createElement("td");
    a.innerHTML = '<a href="' + '/istopics/user/' + author_id + '">' + author + '</a>';
    table_item.appendChild(a);

    var disc = document.createElement("td");
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
    disc.innerHTML = d;
    table_item.appendChild(disc);

    var type = document.createElement("td");
    if (project_type == "senior") {
        type.innerHTML = "Senior IS";
    }
    else if (project_type == "junior") {
        type.innerHTML = "Junior IS";
    }
    else if (project_type == "other") {
        type.innerHTML = "Other";
    }
    table_item.appendChild(type);

    var date = new Date(timestamp);
    var y = document.createElement("td");
    y.innerHTML = date.getFullYear();
    table_item.appendChild(y);

    return table_item;
}
