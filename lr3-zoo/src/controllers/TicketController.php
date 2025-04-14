<?php
namespace src\controllers;

use src\models\Ticket;
use src\services\validators\TicketValidator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Fawno\FPDF\FawnoFPDF;

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

    public function generatePdf(): void
    {   
        function toWin1251($text): string {
            return iconv('UTF-8', 'windows-1251//IGNORE', $text);
        }
        if (session_status() !== PHP_SESSION_NONE 
        && $_SESSION["user"]["email"] !== '' 
        && $_SESSION["user"]["role"] === 'user') {
            $tickets = $this->repository->getUserTickets($_SESSION['user']['email']);
        }
        else{
            $tickets = $this->repository->getAll();
        }
        $pdf = new FawnoFPDF();
        $pdf->AddPage();

        $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
        $pdf->SetFont('DejaVuSans', '', 14);

        $pdf->Cell(0, 10, toWin1251('Список билетов'), 0, 1, 'C');

        $pdf->Ln(5);

        $pdf->SetFont('DejaVuSans', '', 12);
        $pdf->Cell(30, 10, toWin1251('ID'), 1);
        $pdf->Cell(40, 10, toWin1251('Время'), 1);
        $pdf->Cell(30, 10, toWin1251('Стоимость'), 1);
        $pdf->Cell(80, 10, toWin1251('Email'), 1);
        $pdf->Ln();

        foreach ($tickets as $ticket) {
            $pdf->Cell(30, 10, $ticket['ticket_id'], 1);
            $pdf->Cell(40, 10, toWin1251($ticket['ticket_time']), 1);
            $pdf->Cell(30, 10, toWin1251($ticket['ticket_cost']), 1);
            $pdf->Cell(80, 10, toWin1251($ticket['user_email']), 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'tickets.pdf');
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
