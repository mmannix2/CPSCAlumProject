#CREATE DATABASE db;
USE db;

#CREATE TABLE jobs (id NOT NULL PRIMARY KEY AUTO_INCREMENT, name CHAR(25), description CHAR(700));
CREATE TABLE jobs (id NOT NULL PRIMARY KEY, name VARCHAR NOT NULL, companyName VARCHAR NOT NULL, description TEXT(600) NOT NULL);
INSERT INTO jobs (name, description) VALUES ('Java Programmer', 'Company A', 'You will do things.');
INSERT INTO jobs (name, description) VALUES ('Unix System Admin', 'Company B', 'You will do different things.');
INSERT INTO jobs (name, description) VALUES ('Summer Intern', 'Company C', 'You will do more different things.');

#GRANT ALL ON jobs TO *username*;