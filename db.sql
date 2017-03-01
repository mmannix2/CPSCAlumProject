#CREATE DATABASE db;
USE db;

DROP TABLE IF EXISTS jobs;
    
CREATE TABLE jobs (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32) NOT NULL, companyName VARCHAR(32) NOT NULL, description VARCHAR(600) NOT NULL);
INSERT INTO jobs (name, companyName, description) VALUES ('Java Programmer', 'Company A', 'You will do things.');
INSERT INTO jobs (name, companyName, description) VALUES ('Unix System Admin', 'Company B', 'You will do different things.');
INSERT INTO jobs (name, companyName, description) VALUES ('Summer Intern', 'Company C', 'You will do more different things.');

DROP TABLE IF EXISTS volunteers;

CREATE TABLE volunteers (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32) NOT NULL, email VARCHAR(64) NOT NULL, description VARCHAR(600) NOT NULL);
INSERT INTO volunteers (name, email, description) VALUES ('John Doe', 'jdoe@company.com', 'I want to teach the students about Hadoop!');

GRANT SELECT, INSERT ON db.jobs TO 'api'@'localhost';
GRANT SELECT, INSERT ON db.volunteers TO 'api'@'localhost';