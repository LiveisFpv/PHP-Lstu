<?php

namespace App\Service;

use Fawno\FPDF\FawnoFPDF;

class AnimalPdfGenerator
{
    public static function generatePdf(array $animals): string
    {
        function toWin1251($text): string {
            return iconv('UTF-8', 'windows-1251//IGNORE', $text);
        }

        $pdf = new FawnoFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
        $pdf->SetFont('DejaVuSans', '', 14);

        $pdf->Cell(0, 10, toWin1251('Список животных'), 0, 1, 'C');
        $pdf->Ln(10);
    
        $pdf->SetFont('DejaVuSans', '', 12);
        $pdf->Cell(20, 10, toWin1251('ID'), 1);
        $pdf->Cell(40, 10, toWin1251('Имя'), 1);
        $pdf->Cell(30, 10, toWin1251('Пол'), 1);
        $pdf->Cell(30, 10, toWin1251('Возраст'), 1);
        $pdf->Cell(40, 10, toWin1251('Клетка'), 1);
        $pdf->Cell(40, 10, toWin1251('Уход'), 1);
        $pdf->Ln();
    
        foreach ($animals as $animal) {
            $pdf->Cell(20, 10, toWin1251($animal->getId()), 1);
            $pdf->Cell(40, 10, toWin1251($animal->getCare()->getAnimalName()), 1);
            $pdf->Cell(30, 10, toWin1251($animal->getAnimalGender()), 1);
            $pdf->Cell(30, 10, toWin1251($animal->getAnimalAge()), 1);
            $pdf->Cell(40, 10, toWin1251($animal->getAnimalCage()), 1);
            $pdf->Cell(40, 10, toWin1251($animal->getCare()->getCareType()), 1);
            $pdf->Ln();
        }
    
        return $pdf->Output('S');
    }
}