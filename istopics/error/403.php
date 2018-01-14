<?php
/*
* 403.php
*
* Error 403 page
*/

include '../header.php';

echo <<<EOT
    <h2>You must be connected to the College of Wooster network to access that page.</h2>

    <a href='/istopics/project/all' class='btn btn-class'>Return to Safety</a>
EOT;

include '../footer.php';
