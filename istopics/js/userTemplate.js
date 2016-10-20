function user(id, first_name,  last_name, role, major, year, email) {
    var list_item = document.createElement("li");
    list_item.className = id + " well";

    var table = document.createElement("table");
    table.className = "table";
    var tbody = document.createElement("tbody");

    var name_row = document.createElement("tr");
    var name_head = document.createElement("th");
    name_head.innerText = "Name:";
    name_head.className = "col-md-2 col-lg-2";
    var name_data = document.createElement("td");
    name_data.innerText = first_name + " " + last_name;
    name_data.className = "col-md-10 col-lg-10";
    name_row.appendChild(name_head);
    name_row.appendChild(name_data);
    tbody.appendChild(name_row);

    var role_row = document.createElement("tr");
    var role_head = document.createElement("th");
    role_head.innerText = "Role:";
    var role_data = document.createElement("td");
    role_data.innerText = role;
    role_row.appendChild(role_head);
    role_row.appendChild(role_data);
    tbody.appendChild(role_row);

    if (role === 'student') {
        var major_row = document.createElement("tr");
        var major_head = document.createElement("th");
        major_head.innerText = "Major:";
        var major_data = document.createElement("td");
        major_data.innerText = major;
        major_row.appendChild(major_head);
        major_row.appendChild(major_data);
        tbody.appendChild(major_row);

        var year_row = document.createElement("tr");
        var year_head = document.createElement("th");
        year_head.innerText = "Graduation Year:";
        var year_data = document.createElement("td");
        year_data.innerText = year;
        year_row.appendChild(year_head);
        year_row.appendChild(year_data);
        tbody.appendChild(year_row);
    }

    var email_row = document.createElement("tr");
    var email_head = document.createElement("th");
    email_head.innerText = "Email:";
    var email_data = document.createElement("td");
    email_data.innerText = email;
    email_row.appendChild(email_head);
    email_row.appendChild(email_data);
    tbody.appendChild(email_row);

    table.appendChild(tbody);
    list_item.appendChild(table);

    var link = document.createElement("a");
    link.innerText = "Edit Profile";
    link.className = "btn btn-warning";
    link.setAttribute('href', '/user/' + id + '/edit');
    list_item.appendChild(link);

    return list_item;
}