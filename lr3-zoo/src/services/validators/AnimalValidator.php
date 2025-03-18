<?php

    namespace src\services\validators;

    class AnimalValidator{
        public static function validate(array $data): string {
            $animal_name = trim($data['animal-name']?? '');
            $animal_gender = trim($data['animal-gender']?? '');
            $animal_age = trim($data['animal-age']?? '');
            $cage = trim($data['cage']?? '');
            $message ="";
            if(empty($animal_name)){
                $message = $message . "Название животного не может быть пустым.\n";
            }
            elseif (!preg_match('/^(?!-)(?!.*--)(?!.*-$)[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $animal_name)) {
                $message = $message . "Название животного может содержать только буквы, пробелы и дефисы.\n";
            }
            
            if (empty($animal_gender)) {
                $message = $message . "Пол животного не может быть пустым.\n";
            } elseif (!in_array($animal_gender, ["м", "ж"])) {
                $message = $message . "Пол животного должен быть 'м' (мужской) или 'ж' (женский).\n";
            }
            if (!filter_var($animal_age, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 100]])) {
                $message = $message . "Возраст должен быть целым числом от 1 до 100.\n";
            }

            if (!filter_var($cage, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 1000000000]])) {
                $message = $message . "Номер клетки должен быть целым числом от 1 до 1000000000.\n";
            }
            return $message;
        }
    }
?>