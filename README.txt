ISTOPICS
========

Configuration
-------------
The web server should have support for MySQL and a php interpreter with the MySQLi extension installed.

Installation
------------
-place the /istopics folder on the web server
    (probably at /var/www/html)
-run database_setup.sql in MySQL to set up the database and its tables as well as the mySQL user
-the mySQL user 'istopics'@'localhost' is created in the above file and granted necessary permissions
    update username and password in the necessary files appropriately.

File Manifest
-------------
This project has the following file structure:

/istopics
|--README.txt
|--AUTHORS.txt
|--CHANGE_LOG.txt
|--database_setup.sql
|--/istopics
    |--css/
        |--istopics.css
    |--images/
    |--db_credentials.php
    |--deleteProjectController.php
    |--favicon.ico
    |--footer.php
    |--header.php
    |--login.php
    |--loginController.php
    |--logout.php
    |--majors.html
    |--newProject.php
    |--newProjectController.php
    |--newUser.php
    |--newUserController.php
    |--search.php
    |--showAllProjects.php
    |--updateProfile.php
    |--updateProfileController.php
    |--updateProject.php
    |--updateProjectController.php
    |--viewProfile.php
    |--viewProject.php
|--majors/
    |--convert_majors_to_html.py
    |--majors.html
    |--majors.txt

Authors
-------
Read AUTHORS.txt

Change Log
----------
Read CHANGE_LOG.txt
