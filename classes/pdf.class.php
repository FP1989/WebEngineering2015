<?php
include ("FPDF/fpdf.php");

class PDF extends FPDF

{
//    Override FPDF Header
    function Header() {
//        First Line
        $this->SetFont('Helvetica', 'B', 20);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(153, 153, 255);
        $this->Cell(275, 10, 'Report', '', 0, 'L', 1);
        $this->Ln();

//        Second Line
        $this->SetFont('Helvetica', '', 20);
        $this->SetFillColor(206, 212, 236);
        $this->Cell(275, 10, $_SESSION['type'], '', 0, 'L', 1);
        $this->Ln(50);
    }

//    Override FPDF Footer
    function Footer() {
        $this->SetY(-139);
        $this->Image('files/logo_reports.png', 130, 173,'','','','');
        $this->SetY(-6);
        $this->SetFont('Courier','I',12);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(0, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(275, 6, 'Star Reisen AG - 2015', 'T', 0, 'C', 1);
    }

    function createTable($result) {

        if ($result->num_rows > 0) {
            $w = ($_SESSION['type'] == 'Reiseuebersicht' ? 40 : 30);
            $h = 10;

//  Table Header
            $this->SetFont('Helvetica', 'B', 12);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFillColor(206, 212, 236);
            $this->SetTextColor(0, 0, 0);

            while ($finfo = $result->fetch_field()) {
                $this->Cell($w, $h, utf8_decode($finfo->name), 'LTRB', 0, 'C', 1);
            }
            $this->Ln();

//  Table Content
            $fs = ($_SESSION['type'] == 'Kundenuebersicht' ? 8 : ($_SESSION['type'] == 'Reiseuebersicht' ? 8 : 12));

            $this->SetFont('Helvetica', '', $fs);
            $this->SetDrawColor(0, 0, 0);
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);

            while ($row = $result->fetch_assoc()) {
                foreach ($row as $value) {

                    $this->Cell($w, $h, utf8_decode($value), 'LTRB', 0, 'C', 1);
                }
                $this->Ln();
            }
            $this->Ln();
            $this->Output();
        }
}
}