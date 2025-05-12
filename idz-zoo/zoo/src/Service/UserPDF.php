<?php

namespace App\Service;

use Fawno\FPDF\FawnoFPDF;

class UserPdfGenerator
{
    public static function generatePdf(array $users): string
    {
        function toWin1251($text): string {
            return iconv('UTF-8', 'windows-1251//IGNORE', $text);
        }

        $pdf = new FawnoFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
        $pdf->SetFont('DejaVuSans', '', 14);
        $pdf->Cell(0, 10, toWin1251('Список пользователей'), 0, 1, 'C');
        $pdf->Ln(10);
    
        $pdf->SetFont('DejaVuSans', '', 12);
        $pdf->Cell(20, 10, toWin1251('ID'), 1);
        $pdf->Cell(50, 10, toWin1251('Имя'), 1);
        $pdf->Cell(70, 10, toWin1251('Email'), 1);
        $pdf->Cell(60, 10, toWin1251('Роль'), 1);
        $pdf->Ln();
    
        $pdf->SetFont('DejaVuSans', '', 12);
        foreach ($users as $user) {
            $pdf->Cell(20, 10, toWin1251($user->getId()), 1);
            $pdf->Cell(50, 10, toWin1251($user->getUserName()), 1);
            $pdf->Cell(70, 10, toWin1251($user->getUserEmail()), 1);
            $pdf->Cell(60, 10, toWin1251(implode(', ', $user->getUserRole())), 1);
            $pdf->Ln();
        }

        return $pdf->Output('S');
    }
}