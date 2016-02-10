<?php
/*
* showAllProjects.php
* 
* Display all of the projects in the istopics database.
* Topics are sorted alphabetically be default.
*/
?>

<!Doctype HTML>
<HTML>

<head>
    <title>View All</title>
</head>

<body>

<?php
$servername = "localhost";
$username = "istopics";
$password = "password"; //NOTE: CHANGE THE PASSWORD BEFORE GOING INTO PRODUCTION
$dbname = "istopics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<p>Connected successfully</p>";

$sql = "SELECT title, comments FROM projects";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>Project Title: ". $row["title"]. "<br> Comments: ". $row["comments"]. "</p>";
    }
} else {
    echo "<p>Showing 0 results.</p>";
}

//Close connection
$conn->close();
?>

</body>

</HTML>