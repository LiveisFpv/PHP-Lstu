<?php

namespace App\Service;

use Fawno\FPDF\FawnoFPDF;

class TicketPdfGenerator
{
    public static function generatePdf(array $tickets): string
    {
        function toWin1251($text): string {
            return iconv('UTF-8', 'windows-1251//IGNORE', $text);
        }

        $pdf = new FawnoFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
        $pdf->SetFont('DejaVuSans', '', 14);

        $pdf->Cell(0, 10, toWin1251('Список билетов'), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('DejaVuSans', '', 12);

        $pdf->Cell(30, 10, toWin1251('ID'), 1);
        $pdf->Cell(40, 10, toWin1251('Дата'), 1);
        $pdf->Cell(40, 10, toWin1251('Время'), 1);
        $pdf->Cell(30, 10, toWin1251('Стоимость'), 1);
        $pdf->Cell(80, 10, toWin1251('Email'), 1);
        $pdf->Ln();

        foreach ($tickets as $ticket) {
            $pdf->Cell(30, 10, $ticket->getId(), 1);
            $pdf->Cell(40, 10, toWin1251($ticket->getTicketDate()), 1);
            $pdf->Cell(40, 10, toWin1251($ticket->getticketTime()), 1);
            $pdf->Cell(30, 10, toWin1251($ticket->getticketCost()), 1);
            $pdf->Cell(80, 10, toWin1251($ticket->getuserEmail()), 1);
            $pdf->Ln();
        }

        return $pdf->Output('S');
    }
}
