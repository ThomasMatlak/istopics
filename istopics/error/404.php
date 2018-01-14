<?php
/*
* 404.php
*
* Error 404 page
*/

include '../header.php';

echo <<<EOT
    <h2>The Requested Content Could Not Be Found</h2>

    <a href='/istopics/project/all' class='btn btn-class'>Return to Safety</a>
EOT;

include '../footer.php';
