CREATE TABLE IF NOT EXISTS `%table_name%` (
    `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(256) NOT NULL,
    `ext` VARCHAR(256) NOT NULL,
    `content` TEXT NOT NULL,
    `uploader` INT(11) NOT NULL,
    `config` TEXT NOT NULL,
    `timestamp` VARCHAR(256) NOT NULL
);