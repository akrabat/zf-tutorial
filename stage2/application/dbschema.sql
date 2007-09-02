-- MySQL Database Schema

CREATE TABLE album(
	id int(11) NOT NULL AUTO_INCREMENT,
	artist varchar(100) NOT NULL,
	title varchar(100) NOT NULL,
	PRIMARY KEY (id)
);


INSERT INTO album (artist, title)
VALUES (
	'James Morrison', 'Undiscovered'), 
	('Snow Patrol', 'Eyes Open');

CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  real_name varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
);

INSERT INTO users (id, username, password, real_name) 
VALUES (1, 'rob', 'rob', 'Rob Allen');
