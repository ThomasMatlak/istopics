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
    update username and password in /istopics/db_credentials.php and in database_setup.sql
-to change a users's role from 'student' to 'admin', from MySQL run the command:
    UPDATE users SET role='admin' WHERE email='EMAIL OF THE USER TO BE UPDATATED';

Auto Populate the Dabatase (testing)
------------------------------------
1. create a user profile to own all of the projects (from the website)

2. edit python scripts
   -edit db_filler/create_filler_user_project_connections.py by editing line 4 to hold the user id of the user created in step 1.
   -if you want to randomize the user id, uncomment lines 1 and 7
   -edit db_filler/create_filler_user_project_connections.py by editing line 8 to hold the last project id currently in the database (0 if having just run TRUNCATE on the projects table)

3. run db_filler/create_filler_projects.py from the same directory as db_filler/ISkeywords.csv
   -navigate to db_filler/ in the command line
   -enter "python create_filler_projects.py" (omitting the quotes) into the command line

4. run db_filler/create_filler_user-project-connections.py
   -navigate to db_filler/ in the command line
   -enter "python create_filler_user-project-connections.py" (omitting the quotes) into the command line

5. run the generated .sql files from MySQL
   -"SOURCE db_filler/filler_projects.sql;"
   -"SOURCE db_filler/filler_user_project_connections.sql;"
   -there will be some errors in the SQL, but that is okay. Enough INSERTs should succeed to give enough data to test.

File Manifest
-------------
This project has the following file structure:

istopics/
|--README.txt
|--AUTHORS.txt
|--CHANGE_LOG.txt
|--database_setup.sql
|--db_filler/
    |--create_filler_projects.py
    |--create_filler_user_project_connections.py
    |--ISkeywords.csv
|--istopics/
    |--css/
        |--istopics.css
    |--images/
    |--js/
	|--ellipsify.js
	|--expand_contract_pk.js
	|--generateUserEmail.js
	|--newProjectValidation.js
	|--newUsrValidation.js
	|--resetDatabaseWarning.js
	|--searchAllProjects.js
	|--updateProfileValidation.js
	|--updateProjectValidation.js
    |--adminInterface.php
    |--analyticstracking.php
    |--db_credentials.php
    |--deleteProjectController.php
    |--favicon.ico
    |--footer.php
    |--header.php
    |--index.php
    |--login.php
    |--loginController.php
    |--logout.php
    |--majors.html
    |--newProject.php
    |--newProjectController.php
    |--newUser.php
    |--newUserController.php
    |--resetDatabase.php
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
