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
    public function index() {
        // var_dump($_SESSION)
        if (session_status() !== PHP_SESSION_NONE 
        && $_SESSION["user"]["email"] !== '' 
        && $_SESSION["user"]["role"] === 'user') {
            $tickets = $this->repository->getUserTickets($_SESSION['user']['email']);
        }
        else{
            $tickets = $this->repository->getAll();
        }
        echo $this->twig->render('tables/table_ticket.twig', 
        ['tickets' => $tickets,
        'user' => $_SESSION['user'] ?? null,
        ]);
    }
    public function form() {
        $ticketCost = 500;
        $message = $_SESSION["message"] ?? '';
        $_SESSION["message"] = '';

        $timeOptions = [];
        $start = strtotime("09:00");
        $end = strtotime("19:00");
        $interval = 15 * 60;

        for ($time = $start; $time <= $end; $time += $interval) {
            $timeOptions[] = date("H:i", $time);
        }
        echo $this->twig->render('forms/form_ticket.twig', [
            'ticketCost' => $ticketCost,
            'message' => $message,
            'timeOptions' => $timeOptions,
            'user' => $_SESSION['user'] ?? null,
        ]);
    }

    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
