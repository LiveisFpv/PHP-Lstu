<?php

    namespace src\services\validators;

    class CareValidator {
        public static function validate(array $data): string {
            $care_type = trim($data['care-type']?? '');
            $animal_name = trim($data['animal-name'] ?? '');
            $message="";
            if(empty($care_type)){
                $message = $message . "Тип ухода не может быть пустым.\n";
            }
            elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $care_type)) {
                $message = $message . "Тип ухода может содержать только буквы, пробелы и дефисы.\n";
            }
            if(empty($animal_name)){
                $message = $message . "Название животного не может быть пустым.\n";
            }
            elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $animal_name)) {
                $message = $message . "Название животного может содержать только буквы, пробелы и дефисы.\n";
            }
            return $message;
        }
    }

?>