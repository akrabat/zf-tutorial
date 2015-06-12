
CREATE TABLE albums (
  id int(11) NOT NULL auto_increment,
  artist varchar(100) NOT NULL,
  title varchar(100) NOT NULL,
  PRIMARY KEY (id)
);


INSERT INTO albums (artist, title)
VALUES
( 'Paolo Nutine', 'Sunny Side Up' ),
( 'Florence + The Machine', 'Lungs' ),
( 'Massive Attack', 'Heligoland' ),
( 'Andre Rieu', 'Forever Vienna' ),
( 'Sade', 'Soldier of Love' );