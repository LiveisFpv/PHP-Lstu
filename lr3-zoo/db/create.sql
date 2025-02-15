DROP TABLE IF EXISTS animal

CREATE TABLE animal(
    animal_id serial NOT NULL,
    animal_name varchar(255),
    animal_gender varchar(1),
    animal_age integer,
    animal_cage integer,
    animal_care varchar(255),
    PRIMARY KEY (animal_id)
);