<?php

namespace src\services\validators;

class TicketValidator {
    public static function validate(array $data): string {
        $ticket_time = trim($data['ticket_time'] ?? '');
        $ticket_cost = floatval($data['ticket_cost'] ?? 0);
        $user_email = trim($data['user_email'] ?? '');
        $message = "";

        // Валидация времени
        if (empty($ticket_time)) {
            $message .= "Время билета не может быть пустым.\n";
        } elseif (!preg_match('/^([01]?\d|2[0-3]):[0-5]\d$/', $ticket_time)) {
            $message .= "Некорректный формат времени. Используйте HH:MM.\n";
        } else {
            $time = strtotime($ticket_time);
            $min_time = strtotime("09:00");
            $max_time = strtotime("19:00");

            if ($time < $min_time || $time > $max_time) {
                $message .= "Билеты доступны только с 09:00 до 19:00.\n";
            } elseif ((date("i", $time) % 15) !== 0) {
                $message .= "Время должно быть кратно 15 минутам (например, 09:00, 09:15, 09:30).\n";
            }
        }

        // Валидация цены билета
        if ($ticket_cost <= 0) {
            $message .= "Цена билета должна быть больше нуля.\n";
        }

        // Валидация email
        if (empty($user_email)) {
            $message .= "Email не может быть пустым.\n";
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $message .= "Некорректный email.\n";
        }

        return $message;
    }
}

?>
