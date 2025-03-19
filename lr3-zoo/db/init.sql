DROP TABLE IF EXISTS `animals`;
DROP TABLE IF EXISTS `care`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `care` (
    `care_id` SERIAL PRIMARY KEY,
    `care_type` VARCHAR(255) NOT NULL,
    `animal_name` VARCHAR(255) UNIQUE
);

CREATE TABLE `animals` (
    `animal_id` SERIAL PRIMARY KEY,
    `animal_name` VARCHAR(255) NOT NULL,
    `animal_gender` CHAR(1) NOT NULL,
    `animal_age` INT NOT NULL,
    `animal_cage` INT NOT NULL,
    FOREIGN KEY (`animal_name`) REFERENCES `care` (`animal_name`)
);

CREATE TABLE `users`(
    `user_id` SERIAL PRIMARY KEY,
    `user_name` VARCHAR(255) NOT NULL,
    `user_email` VARCHAR(255) UNIQUE,
    `user_password` VARCHAR(255) NOT NULL,
    `user_role` VARCHAR(255) NOT NULL
);