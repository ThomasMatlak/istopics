# Run this file as a user with permissions to create users

# Create database for istopics
DROP DATABASE IF EXISTS istopics;
CREATE DATABASE istopics;
USE istopics;

# Create Tables
# users
DROP TABLE IF EXISTS users;
CREATE TABLE users (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(35), last_name VARCHAR(35), email VARCHAR(255), major VARCHAR(100), password VARCHAR(100), year INT, role VARCHAR(7), password_reset_key VARCHAR(100), password_reset_expiration DATETIME, activated BOOLEAN, UNIQUE (email));

# projects
DROP TABLE IF EXISTS projects;
create table projects (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(500), proposal TEXT, keywords VARCHAR(1000), comments VARCHAR(1000), discipline VARCHAR(100), project_type ENUM('senior', 'junior', 'other'), date_created DATETIME, last_updated TIMESTAMP);

# relational table for user ownership of projects
DROP TABLE IF EXISTS user_project_connections;
CREATE TABLE user_project_connections (userid INT, projectid INT);

# relation table for users to favorite projects
DROP TABLE IF EXISTS user_project_favorites;
CREATE TABLE user_project_favorites (userid INT, projectid INT);

# Store ui elements in the database
# header links
DROP TABLE IF EXISTS header_links;
CREATE TABLE header_links (link TEXT, visible_text TEXT, required_priveleges TEXT, link_order INT);
INSERT INTO header_links (link, visible_text, required_priveleges, link_order) VALUES
	('/project/all', 'View All Projects', 'none', 0),
	('/project/new', 'Add a New Project', 'student', 1),
	('/user', 'Hello ', 'signin', 2),
	('/user/favorites', 'Your Favorites', 'signin', 3),
	('/logout.php', 'Sign Out', 'signin', 4),
	('/admin', 'Administrator Interface', 'admin', 5),
	('/signin', 'Sign In', 'signout', 6),
	('/register', 'New User?', 'signout', 7);

# Remove user istopics if already exists
DROP USER 'istopics'@'localhost';

# Create user istopics - change the password for use in a production environment
CREATE USER 'istopics'@'localhost' IDENTIFIED BY 'password';

# Grant permissions
# For use in production
GRANT SELECT, DELETE, INSERT, UPDATE, DROP ON istopics.* TO 'istopics'@'localhost';

# For use in testing
#GRANT ALL ON istopics.* TO 'istopics'@'localhost';
