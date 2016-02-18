ISTOPICS
========

Configuration
-------------
The web server should have support for MySQL and a php interpreter with the MySQLi extenstion installed.

Installation
------------
-place the /istopics folder on the web server
    (probably at /var/www/html)
-run database_setup.sql in MySQL to set up the database and its tables
-create a MySQL user that only has access to the istopics database(!),
    update username and password in the necessary files(?) appropriately.

File Manifest
-------------
This project has the following file structure:

/istopics
|--README.txt
|--AUTHORS.txt
|--CHANGE_LOG.txt
|--database_setup.sql
|--/istopics
    |--deleteProjectController.php
    |--footer.php
    |--header.php
    |--majors.html
    |--newProject.php
    |--newProjectController.php
    |--newUser.php
    |--newUserController.php
    |--search.php
    |--showAllProjects.php
    |--updateProject.php
    |--updateProjectController.php
    |--viewProject.php
|--/majors
    |--convert_majors_to_html.py
    |--majors.html
    |--majors.txt

Authors
-------
Read AUTHORS.txt

Change Log
----------
Read CHANGE_LOG.txt
