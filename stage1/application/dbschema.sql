-- MySQL Database Schema

CREATE TABLE albums (
	id int(11) NOT NULL AUTO_INCREMENT,
	artist varchar(100) NOT NULL,
	title varchar(100) NOT NULL,
	PRIMARY KEY (id)
);


INSERT INTO album (artist, title)
VALUES (
	'James Morrison', 'Undiscovered'), 
	('Snow Patrol', 'Eyes Open');