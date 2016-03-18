CREATE DATABASE IF NOT EXISTS pegmata;

use pegmata;

CREATE TABLE `pages` (
	`id` TINYINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
	`alias` VARCHAR(32) NOT NULL,
	`title` VARCHAR(32) NOT NULL,
	`content` TEXT DEFAULT NULL,
	`is_published` TINYINT(1) UNSIGNED DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`alias`, `title`, `content`, `is_published`)
	VALUES ('about', 'About', 'Test and so on..', 1);
	
CREATE TABLE `messages` (
	`id` TINYINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL,
	`email` VARCHAR(64) NOT NULL,
	`message` TEXT DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `users` (
	`id` TINYINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(32) NOT NULL,
	`email` VARCHAR(32) NOT NULL,
	`role` VARCHAR(32) NOT NULL DEFAULT 'admin',
	`password` CHAR(64) NOT NULL,
	`is_active` TINYINT(1) UNSIGNED DEFAULT 1,
	PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO `users` (`username`, `email`, `role`, `password`, `is_active`) 
	VALUES ('admin', 'admin@pegmata.local', 'admin', SHA2('7709988956eb2fdc71aad2.35020583admin', '256'), 1)