#CREATE DATABASE db;
USE db;

DROP TABLE IF EXISTS jobs;
    
CREATE TABLE jobs (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32) NOT NULL, companyName VARCHAR(32) NOT NULL, description VARCHAR(600) NOT NULL);
INSERT INTO jobs (name, companyName, description) VALUES ('Java Programmer', 'Company A', 'You will do things. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent posuere luctus dui vel varius. Maecenas lacinia dolor eu nibh lacinia efficitur. Vestibulum quis fringilla turpis. Aliquam erat volutpat. Phasellus eleifend et neque in malesuada. Morbi gravida convallis efficitur. Nam eu enim sapien. Praesent mauris mauris, porta id quam aenean suscipit.');
INSERT INTO jobs (name, companyName, description) VALUES ('Unix System Admin', 'Company B', 'You will do different things. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin tempus augue id molestie. Etiam mollis mi mauris, sed congue neque ornare ut. Nam viverra odio est, at rutrum ante imperdiet eget. In tristique sagittis ex, non maximus nisi euismod et. Aliquam ac maximus sed.');
INSERT INTO jobs (name, companyName, description) VALUES ('Summer Intern', 'Company C', 'You will do more different things. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat tincidunt arcu accumsan luctus. Vivamus consequat nisl mauris, vel molestie sem consequat ac. Aliquam erat volutpat. Nunc ante elit, tristique id consequat et, fringilla nec diam. Phasellus felis eros, lacinia a turpis et, imperdiet cursus diam. Nulla tristique condimentum orci tempor posuere. Sed et ante iaculis cras amet.');
INSERT INTO jobs (name, companyName, description) VALUES ('Very Verbose Job Description', 'Company D', 'This is a maximum length job post. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nunc risus, accumsan eget mollis ac, feugiat eu sem. In eget risus tortor. Sed pellentesque tincidunt dolor, eu pulvinar leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non elit at leo vestibulum faucibus sed vitae nunc. Etiam ut augue et elit consectetur convallis. Sed vitae aliquam velit. Ut egestas consequat lectus a porttitor. Fusce euismod varius odio, in aliquam dolor bibendum non. Morbi eget laoreet nunc, eget feugiat leo. Nulla in vulputate augue, ut viverra se metus.');
DROP TABLE IF EXISTS volunteers;

CREATE TABLE volunteers (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32) NOT NULL, email VARCHAR(64) NOT NULL, description VARCHAR(600) NOT NULL);
INSERT INTO volunteers (name, email, description) VALUES ('John Doe', 'jdoe@company.com', 'I want to teach the students about Hadoop!');

GRANT SELECT, INSERT ON db.jobs TO 'api'@'localhost';
GRANT SELECT, INSERT ON db.volunteers TO 'api'@'localhost';