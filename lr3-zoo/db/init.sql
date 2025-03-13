DROP TABLE IF EXISTS `animal`;

CREATE TABLE `animal` (
    `animal_id` SERIAL PRIMARY KEY,
    `animal_name` VARCHAR(255),
    `animal_gender` CHAR(1),
    `animal_age` INT,
    `animal_cage` INT,
    `animal_care` VARCHAR(255)
);
