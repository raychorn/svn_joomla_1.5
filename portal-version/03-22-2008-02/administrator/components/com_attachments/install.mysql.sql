CREATE TABLE IF NOT EXISTS `#__attachments`
(
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`filename` VARCHAR(80) NOT NULL,
	`filename_sys` VARCHAR(255) NOT NULL,
	`file_type` VARCHAR(30) NOT NULL,
	`file_size` INT(6) UNSIGNED NOT NULL,
	`icon_filename` VARCHAR(20) NOT NULL,
	`display_filename` VARCHAR(80) NOT NULL,
	`description` VARCHAR(255) NOT NULL,
	`url` VARCHAR(255) NOT NULL,
	`uploader_id` INT(11) NOT NULL,
	`article_id` INT(11) UNSIGNED NOT NULL,
	`published` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);
