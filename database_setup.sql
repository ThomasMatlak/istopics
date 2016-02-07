#Create database for istopics
create database istopics;
use istopics;

#Create Tables
#users
create table users (id INT not null auto_increment primary key, first_name VARCHAR(35), last_name VARCHAR(35), email VARCHAR(255), major VARCHAR(100));
#projects
create table projects (id INT not null auto_increment primary key, title VARCHAR(500), abstract TEXT, keywords VARCHAR(1000), comments VARCHAR(1000));
#relational table for users and projects
create table user_project_connections (id INT not null auto_increment primary key, userid INT, projectid INT);
