<?php

namespace src\models;

use src\repository\Database;

use PDO;

class Ticket{
    private PDO $pdo;
    public function __construct(){
        $this->pdo = Database::connect();
    }
    public function getUserTickets(string $email): array {
        $stmt = $this->pdo->prepare("SELECT * FROM tickets WHERE user_email=:user_email");
        $stmt->execute([
            'user_email' => $email
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM tickets");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addTicket($ticket_date,$ticket_time, float $ticket_cost, string $user_email): bool {
        $stmt = $this->pdo->prepare("INSERT INTO tickets (ticket_date,ticket_time, ticket_cost, user_email) VALUES (:ticket_date,:ticket_time, :ticket_cost, :user_email)");
        $success=$stmt->execute([
            'ticket_date' => $ticket_date,
            'ticket_time' => $ticket_time,
            'ticket_cost' => $ticket_cost,
            'user_email' => $user_email,
        ]);
        return $success;
    }
}

?>