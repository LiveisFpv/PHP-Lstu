<?php
namespace src\controllers;

use src\models\Ticket;
use src\services\validators\TicketValidator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TicketController {
    private Environment $twig;
    private Ticket $repository;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new Environment($loader);
        $this->repository = new Ticket();
    }

    public function form() {
        include __DIR__ . '/../views/forms/form_ticket.php';
    }

    public function create() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /tickets/create");
            exit;
        }

        $message = TicketValidator::validate($_POST);
        if ($message !== '') {
            $_SESSION["message"] = $message;
            header("Location: /tickets/create");
            exit;
        }

        $ticket_time = trim($_POST['ticket_time'] ?? '');
        $ticket_cost = floatval($_POST['ticket_cost'] ?? 0);
        $user_email = trim($_POST['user_email'] ?? '');

        $success = $this->repository->addTicket($ticket_time, $ticket_cost, $user_email);

        if ($success) {
            $_SESSION["message"] = "Билет успешно куплен!";
        } else {
            $_SESSION["message"] = "Ошибка при покупке билета.";
        }

        header("Location: /tickets/create");
        exit;
    }
}
?>
