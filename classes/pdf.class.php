<?php

include ("database.class.php");
include ("fpdf/fpdf.php");

class PDF extends FPDF
{

    public function createTable($type) {

        /** @var database $verbindung */
        $verbindung = database::getDatabase();
        $result = $verbindung->generateReport($type);

        if ($result->num_rows > 0) {

            $w = $type == 'Reiseuebersicht' ? 40 : 30;
            $h = 10;
            $pdf = new FPDF();
            $pdf->AddPage('L');
            $pdf->SetFont('Helvetica', 'B', 20);
            $pdf->Cell(40, 10, 'Report: ' . $type);
            $pdf->Ln();
            $pdf->Ln();

/*Header*/
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(206, 212, 236);
            $pdf->SetTextColor(0, 0, 0);

            while ($finfo = $result->fetch_field()) {
                $pdf->Cell($w, $h, utf8_decode($finfo->name), 'LTRB', 0, 'C', 1);
            }
            $pdf->Ln();

/*Content*/
            $fs = ($type == 'Kundenuebersicht' ? 8 : ($type == 'Reiseuebersicht' ? 8 : 12));

            $pdf->SetFont('Helvetica', '', $fs);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);

            $x = $pdf->GetX();
            $y = $pdf->GetY();

            while ($row = $result->fetch_assoc()) {
                foreach ($row as $value) {
                    $pdf->Cell($w, $h, utf8_decode($value), 'LTRB', 0, 'C', 1);
                }
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->Output();
        }
    }
}