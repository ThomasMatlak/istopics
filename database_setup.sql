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
create table projects (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(500), proposal TEXT, keywords VARCHAR(1000), comments VARCHAR(1000), discipline VARCHAR(100), date_created DATETIME, last_updated TIMESTAMP);

# relational table for user ownership of projects
DROP TABLE IF EXISTS user_project_connections;
CREATE TABLE user_project_connections (userid INT, projectid INT);

# relation table for users to favorite projects
DROP TABLE IF EXISTS user_project_favorites;
CREATE TABLE user_project_favorites (userid INT, projectid INT);

# Remove user istopics if already exists
DROP USER 'istopics'@'localhost';

# Create user istopics - change the password for use in a production environment
CREATE USER 'istopics'@'localhost' IDENTIFIED BY 'password';

# Grant permissions
# For use in production
GRANT SELECT, DELETE, INSERT, UPDATE, DROP ON istopics.* TO 'istopics'@'localhost';

# For use in testing
#GRANT ALL ON istopics.* TO 'istopics'@'localhost';
