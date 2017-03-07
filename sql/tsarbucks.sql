/* Creating the Database */
CREATE DATABASE IF NOT EXISTS tsarbucks;
ALTER DATABASE tsarbucks
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_unicode_ci;

/* Creating the products table */
DROP TABLE IF EXISTS `tsarbucks`.`products`;
CREATE TABLE `tsarbucks`.`products` (
	`product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`display_name` varchar(255) NOT NULL,
	`price` DECIMAL(4, 2) NOT NULL,
	`size` tinyint(2) NOT NULL COMMENT 'size in ounces',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`product_id`)
);

/* Creating the orders table */
DROP TABLE IF EXISTS `tsarbucks`.`orders`;
CREATE TABLE `tsarbucks`.`orders` (
	`order_id` int(10) unsigned NOT NULL,
	`user_id` int(10) NOT NULL,
	`product_id` int(10) NOT NULL,
	`quantity` int(10) NOT NULL,
	`completed` boolean NOT NULL DEFAULT 0,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`order_id`, `user_id`, `product_id`)
);

/* Creating the users table */
DROP TABLE IF EXISTS `tsarbucks`.`users`;
CREATE TABLE `tsarbucks`.`users` (
	`user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`display_name` varchar(255) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated_at` TIMESTAMP NULL DEFAULT NULL,
  	PRIMARY KEY (`user_id`),
  	UNIQUE (`username`)
);

/* Creating the roles table */
DROP TABLE IF EXISTS `tsarbucks`.`roles`;
CREATE TABLE `tsarbucks`.`roles` (
	`system_name` varchar(32) NOT NULL,
	`display_name` varchar(32) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated_at` TIMESTAMP NULL DEFAULT NULL,
  	PRIMARY KEY (`system_name`)
);

/* Creating the user_roles table */
DROP TABLE IF EXISTS `tsarbucks`.`user_roles`;
CREATE TABLE `tsarbucks`.`user_roles` (
	`user_id` int(10) unsigned NOT NULL,
	`role` varchar(32) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`updated_at` TIMESTAMP NULL DEFAULT NULL,
  	PRIMARY KEY (`user_id`, `role`)
);

/* Populating the products table */
INSERT INTO `tsarbucks`.`products` (`product_id`, `display_name`, `price`, `size`)
VALUES
	(1, 'Black Coffee (Small)', 5.00, 2),
	(2, 'Black Coffee (Medium)', 7.50, 4),
	(3, 'Black Coffee (Large)', 10.00, 8),
	(4, 'Espresso (Small)', 6.00, 1),
	(5, 'Espresso (Large)', 12.00, 2),
	(6, 'Tsartisan Coffee (Small)', 10.00, 4),
	(7, 'Tsartisan Coffee (Large)', 20.00, 8),
	(8, 'Plum Floating in Perfume, Served in a Man\'s Hat', 15.00, 16);

/* Populating the users table; passwords are the same as the usernames */
INSERT INTO `tsarbucks`.`users` (`user_id`, `username`, `password`, `display_name`)
VALUES
	(1, 'customer', 'b39f008e318efd2bb988d724a161b61c6909677f', 'Customer'),
	(2, 'barista', 'e1386ca049393ffb6bba56d5a5106ae72e6a9e13', 'Barista');

/* Populating the roles table */
INSERT INTO `tsarbucks`.`roles` (`system_name`, `display_name`)
VALUES
	('customer', 'Customer'),
	('barista', 'Barista');

/* Populating the user_roles table */
INSERT INTO `tsarbucks`.`user_roles` (`user_id`, `role`)
VALUES
	(1, 'customer'),
	(2, 'barista');

/* Populating the orders table */
INSERT INTO `tsarbucks`.`orders` (`order_id`, `user_id`, `product_id`, `quantity`, `completed`)
VALUES
	(1, 1, 1, 2, 1),
	(1, 1, 2, 4, 1),
	(1, 1, 3, 1, 1),
	(2, 1, 2, 5, 1),
	(2, 1, 5, 2, 1),
	(3, 1, 4, 1, 1),
	(4, 1, 8, 1, 1),
	(4, 1, 6, 3, 1),
	(5, 1, 7, 2, 0),
	(6, 1, 3, 4, 0);
