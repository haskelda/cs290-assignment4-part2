CREATE TABLE `videoshoppe` (
`id` int(11) AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`category` varchar(255),
`length` int(11) UNSIGNED,
`rented` bool NOT NULL DEFAULT FALSE,
PRIMARY KEY(`id`),
UNIQUE KEY (`name`)
) ENGINE=InnoDB;

INSERT INTO videoshoppe (name, category, length) VALUES 
("Matrix", "Action", 121),
("Romancing The Stone", "Romance", 123),
("Andromeda Strain", "Sci-fi", 201);

INSERT INTO videoshoppe (name, category, length) VALUES 
("Die Hard", "Action", 120);

UPDATE videoshoppe 
SET rented = 1
WHERE id = 3;

DELETE FROM videoshoppe WHERE id = ?