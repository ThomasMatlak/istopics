<?php
/*
* dbToCSV.php
*
* Download all projects in the database as a CSV file
*/

require_once 'db_credentials.php';
require_once 'checkSignIn.php';

if (issignedin() == 'admin') {

    $sql = "SELECT id, title, discipline, keywords, proposal, comments FROM projects";

    $result = $conn->query($sql);

    $outputFile = fopen("php://output", "w");

    fputcsv($outputFile, array('id', 'title', 'major', 'keywords', 'proposal', 'comments'));

    // download the file
    $today = date("Y-m-d");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

    // force download  
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: application/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=istopics_project_{$today}.csv");

    // put results into the file
    while ($row = $result->fetch_assoc()) {
        fputcsv($outputFile, $row);
    }

    fclose($outputFile);

    $conn->close();
}
else {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "You are not authorized to perform this action.";

    header("Location: /project/all");
    exit();
}

?>