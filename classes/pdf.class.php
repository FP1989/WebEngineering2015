<?php
include ("FPDF/fpdf.php");

class PDF extends FPDF {

    private $hwidth = 275;
    private $cwidth = 40;
    private $cheight = 10;
    private $fsize = 10;
    private $font = 'Arial';
    private $footerfont = 'Courier';
    private $white = 255;
    private $black = 0;
    private $grey = 228;

//    Defines at what Y-Coordinate the page is broken
    private $maxheight = 250;

//    Override FPDF Header
    function Header() {
//        First Line
        $this->SetFont($this->font, 'B', $this->fsize + 10);
        $this->SetDrawColor($this->black, $this->black, $this->black);
        $this->SetTextColor($this->black, $this->black, $this->black);
        $this->SetFillColor($this->black, $this->black, $this->black);
        $this->Cell($this->hwidth, $this->cheight-8, '', '', 0, 'L', 1);
        $this->Ln(2);

//        Second Line
        $this->SetFillColor($this->white, $this->white, $this->white);
        $title = utf8_decode($_SESSION['type']);
        $this->Cell($this->hwidth-50, $this->cheight, "REPORT: " . $title, '', 0, 'L', 1);
        $this->Ln(10);

//        Third Line
        $this->SetFillColor($this->black, $this->black, $this->black);
        $this->Cell($this->hwidth, $this->cheight-9, '', '', 0, 'L', 1);
        $this->Ln(20);
    }


//    Override FPDF Footer
    function Footer() {
        $this->SetY(-6);
        $this->SetFont($this->footerfont,'I',$this->fsize+2);
        $this->SetDrawColor($this->black, $this->black, $this->black);
        $this->SetFillColor($this->black, $this->black, $this->black);
        $this->SetTextColor($this->white, $this->white, $this->white);
        $this->Cell($this->hwidth, $this->fsize-4, 'Star Reisen AG - 2015 - Seite ' . $this->PageNo() . ' von {nb}', 'T', 0, 'C', 1);
        $this->SetTextColor($this->black, $this->black, $this->black);
    }

    function createTable($result) {

        if ($result->num_rows > 0) {

//  Table Header
            $this->SetFont($this->font, 'B', 12);
            $this->SetDrawColor($this->black, $this->black, $this->black);
            $this->SetFillColor($this->black, $this->black, $this->black);
            $this->SetTextColor($this->white, $this->white, $this->white);
            $this->cwidth = ($_SESSION['type'] == 'Kundenkontakt') ? 55 : 40;

            while ($finfo = $result->fetch_field()) {
                $this->Cell($this->cwidth, $this->cheight, utf8_decode($finfo->name), 'LTRB', 0, 'C', 1);
            }
            $this->Ln();

//  Table Content
            $this->SetFont($this->font, '', $this->fsize);
            $this->SetDrawColor($this->black, $this->black, $this->black);
            $this->SetFillColor($this->white, $this->white, $this->white);
            $this->SetTextColor($this->black, $this->black, $this->black);
            $pagecounter = 0;
            $linecounter = 0;
            $this->cwidth = ($_SESSION['type'] == 'Kundenkontakt') ? 55 : 40;

            while ($row = $result->fetch_assoc()) {

                if ($pagecounter < $this->maxheight){
                    if($linecounter%2 != 0) $this->SetFillColor($this->grey, $this->grey, $this->grey); else $this->SetFillColor($this->white, $this->white, $this->white);
                    foreach ($row as $value) {
                        $this->Cell($this->cwidth, $this->cheight, utf8_decode($value), 'LTRB', 0, 'C', 1);
                        $linecounter++;
                    }
                } else {
                    $this->AddPage('L');
                    foreach ($row as $value) {
                        $this->Cell($this->cwidth, $this->cheight, utf8_decode($value), 'LTRB', 0, 'C', 1);
                        $linecounter++;
                    }
                }
                $pagecounter = $this->GetY();
                $this->Ln();
            }
            $this->Output();
        }
    }
}
