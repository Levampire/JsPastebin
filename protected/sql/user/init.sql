CREATE TABLE IF NOT EXISTS `%table_name%` (
    `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(256) NOT NULL,
    `email` VARCHAR(256) NOT NULL,
    `token` VARCHAR(256) NOT NULL
);