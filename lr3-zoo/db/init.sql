DROP TABLE IF EXISTS `animals`;

CREATE TABLE `animals` (
    `animal_id` SERIAL PRIMARY KEY,
    `animal_name` VARCHAR(255),
    `animal_gender` CHAR(1),
    `animal_age` INT,
    `animal_cage` INT,
);

CREATE TABLE `care` (
    `care_id` SERIAL PRIMARY KEY,
    `care_type` VARCHAR(255),
    `animal_name` INT UNIQUE,
    FOREIGN KEY (`animal_name`) REFERENCES `animals` (`animal_name`)
)

CREATE TABLE `users`(
    `user_id` SERIAL PRIMARY KEY,
    `user_name` VARCHAR(255),
    `user_email` VARCHAR(255) UNIQUE,
    `user_password` VARCHAR(255),
    `user_role` VARCHAR(255)
)