CREATE TABLE `videoshoppe` (
`id` int(11) AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`category` varchar(255),
`length` int(11) UNSIGNED NOT NULL,
`rented` bool DEFAULT FALSE,
PRIMARY KEY(`id`),
UNIQUE KEY (`name`)
) ENGINE=InnoDB;