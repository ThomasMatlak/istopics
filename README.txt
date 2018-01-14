ISTOPICS
========

Configuration
-------------
The web server should have support for MySQL and a php interpreter with the MySQLi extension installed.

To allow for the .htaccess file to work, the server must be configured to allow this
    This can be accomplished on a Linux Apache server by editing /etc/apache2/sites-enabled/000-default.conf (or a very similar name) to include the following code:

    <Directory /var/www/html>
        AllowOverride All
    </Directory>

    Replace /var/www/html with the server's web root

    Then, the command "a2enmod rewrite" must be run to enable mod_rewrite
    Finally, restart the server: "service apache2 restart"

    If you want to use a virtual host, see your web server's documentation.

    Web root url should be localhost/istopics, or some such.

Installation
------------
-place the /istopics folder on the web server
    (probably at /var/www/html)
-run database_setup.sql in MySQL to set up the database and its tables as well as the mySQL user
-the mySQL user 'istopics'@'localhost' is created in the above file and granted necessary permissions
    update username and password in /istopics/db_credentials.php and in database_setup.sql
-to change a users's role from 'student' to 'admin', from MySQL run the command:
    UPDATE users SET role='admin' WHERE email='EMAIL OF THE USER TO BE UPDATATED';

To use Google Analytics, replace the x's on line 8 of istopics/analyticstranking.php with your own code

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

Directory Layout
----------------
This project has the following directory structure:

istopics/ Contains meta information about the project and subdirectories containing parts of the project
|--db_filler/ Contains code to generate filler projects during development
|--istopics/ Contains PHP files
    |--css/ Contains custom CSS
    |--error/ Contains PHP pages for custom server error messages
    |--js/ Contains custom JavaScript code
|--majors/ Contains code to generate an HTML list of majors offered at The College of Wooster

Authors
-------
See AUTHORS.txt

Change Log
----------
See CHANGE_LOG.txt
