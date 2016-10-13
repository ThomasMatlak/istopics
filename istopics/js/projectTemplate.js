function project(id, title, author, author_id, discipline, proposal, keywords) {
    var list_item = document.createElement("li");
    list_item.className = id;

    var panel = document.createElement("div");
    panel.className = "panel panel-default";

    var panel_heading = document.createElement("div");
    panel_heading.className = "panel-heading container-fluid";

    var t = document.createElement("a");
    t.innerText = title;
    t.id = id + 'project_title';
    t.className = "btn btn-link text-left col-xs-11 col-sm-11 col-md-11 col-ls-11";
    t.href = "/project?project_id=" + id;

    panel_heading.appendChild(t);
    panel.appendChild(panel_heading);

    var panel_body = document.createElement("div");
    panel_body.className = "panel-body";

    var table = document.createElement("table");
    table.className = "table";

    var caption = document.createElement("caption");
    caption.innerHTML = "<span id='" + id + "author'><a href='/user?user_id=" + author_id + "'>" + author + "</a></span></caption>";
    table.appendChild(caption);

    // discipline
    var discipline_row = document.createElement("tr");
    var discipline_head = document.createElement("th");
    discipline_head.className = "col-xs-1 col-sm-1 col-md-1 col-lg-1";
    discipline_head.innerText = "Major:";
    discipline_row.appendChild(discipline_head);
    var discipline_data = document.createElement("td");
    discipline_data.className = "col-xs-11 col-sm-11 col-md-11 col-lg-11";
    discipline_data.innerText = discipline;

    discipline_row.appendChild(discipline_data);
    table.appendChild(discipline_row);

    // proposal
    var prop = document.createElement("tr");
    var prop_head = document.createElement("th");
    prop_head.innerText = "Proposal:";
    prop.appendChild(prop_head);
    var prop_data = document.createElement("td");
    prop_data.innerText = proposal;

    prop.appendChild(prop_data);
    table.appendChild(prop);

    // keywords
    var key = document.createElement("tr");
    var key_head = document.createElement("th");
    key_head.innerText = "Keywords:";
    key.appendChild(key_head);
    var key_data = document.createElement("td");
    key_data.innerText = keywords;

    key.appendChild(key_data);
    table.appendChild(key);

    panel_body.appendChild(table);
    panel.appendChild(panel_body);
    list_item.appendChild(panel);

    return list_item;
}
