<?php
/**
 * Download projects from the database as a CSV file
 */

require_once 'db_credentials.php';
require_once 'checkSignIn.php';

if (issignedin() == 'admin') {

    $sql = "SELECT id, project_type, discipline, title, keywords, proposal, comments, date_created, last_updated FROM projects";

    if ((isset($_POST['discipline']) && $_POST['discipline'] != '') || $_POST['other_discipline'] != '' || $_POST['year'] != '' || $_POST['project_keywords'] != '' || (isset($_POST['project_type']) && $_POST['project_type'] != '')) {
        $sql .= " WHERE ";

        if ($_POST['other_discipline'] != '') {
            $sql .= "discipline LIKE '%{$_POST['other_discipline']}%'";
        }
        if (isset($_POST['discipline'])) {
            if ($_POST['other_discipline']) {
                $sql .= ' OR ';
            }
            if (! is_array($_POST['discipline'])) {
                $sql .= "discipline LIKE '%{$_POST['discipline']}%'";
            }
            elseif (count($_POST['discipline']) == 1) {
                $sql .= "discipline LIKE '%{$_POST['discipline'][0]}%'";
            }
            else {
                $first_disc = true;
                foreach ($_POST['discipline'] as $disc) {
                    if ($first_disc !== true) {
                        $sql .= ' OR ';
                    }
                    else {
                        $first_disc = false;
                    }
                    $sql .= "discipline LIKE '%{$disc}%'";
                }
            }
        }
        if ($_POST['project_keywords']) {
            if (isset($_POST['discipline'])) {
                $sql .= ' OR ';
            }
            $keywords = explode(',', $_POST['project_keywords']);

            $first_key = true;
            foreach ($keywords as $k) {
                if ($first_key !== true) {
                    $sql .= ' OR ';
                }
                else {
                    $first_key = false;
                }
                $sql .= "keywords LIKE '%{$k}%'";
            }
        }
        if (isset($_POST['project_type']) && count($_POST['project_type']) > 0) {
            if (isset($_POST['discipline']) || $_POST['other_discipline'] || $_POST['project_keywords']) {
                $sql .= ' AND ';
            }
            $sql .= '(';

            $first_type = true;
            foreach($_POST['project_type'] as $type) {
                if ($first_type !== true) {
                    $sql .= ' OR ';
                }
                else {
                    $first_type = false;
                }
                $sql .= "project_type LIKE '%{$type}%'";
            }

            $sql .= ')';
        }
        if (isset($_POST['year'])) {
            if (isset($_POST['discipline']) || $_POST['other_discipline'] || $_POST['project_keywords'] || isset($_POST['project_type'])) {
                $sql .= ' AND ';
            }
            $sql .= "YEAR(date_created)={$_POST['year']}";
        }
    }

    $result = $conn->query($sql);

    $outputFile = fopen("php://output", "w");

    if ($_POST['data_format'] == 'csv') {
        fputcsv($outputFile, array('id', 'project_type', 'major', 'title', 'keywords', 'proposal', 'comments', 'date_created', 'last_updated'));
    }
    else if ($_POST['data_format'] == 'json') {
        $projects = array();
    }

    // download the file
    $today = date("Y-m-d");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

    // force download
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: application/csv; charset=utf-8');
    if ($_POST['data_format'] == 'csv') {
        header("Content-Disposition: attachment; filename=istopics_projects_{$today}.csv");
    }
    else if ($_POST['data_format'] == 'json') {
        header("Content-Disposition: attachment; filename=istopics_projects_{$today}.json");
    }

    // put results into the file
    if ($_POST['data_format'] == 'csv') {
        while ($row = $result->fetch_assoc()) {
            fputcsv($outputFile, $row);
        }
    }
    else if ($_POST['data_format'] == 'json') {
        while ($row = $result->fetch_assoc()) {
            $projects[] = array(
                'id' => $row['id'],
                'project_type' => $row['project_type'],
                'major' => $row['discipline'],
                'title' => $row['title'],
                'keywords' => $row['keywords'],
                'proposal' => $row['proposal'],
                'comments' => $row['comments'],
                'date_created' => $row['date_created'],
                'last_updated' => $row['last_updated'],
            );
        }

        $projects_file['projects'] = $projects;
        fwrite($outputFile, json_encode($projects_file));
    }

    fclose($outputFile);

    $conn->close();
}
else {
    $_SESSION["error"] = 1;
    $_SESSION["error_msg"] = "You are not authorized to perform this action.";

    header("Location: /istopics/project/all");
    exit();
}
