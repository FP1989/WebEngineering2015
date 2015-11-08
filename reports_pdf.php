<?php
session_start();
include ("classes/database.class.php");
include ("classes/fpdf/fpdf.php");

/** @var database $verbindung */
$verbindung = database::getDatabase();
$result = $verbindung->generateReport($_SESSION['type']);

if ($result->num_rows > 0) {

    $w = ($_SESSION['type'] == 'Reiseuebersicht' ? 40 : 30);
    $h = 10;
    $pdf = new FPDF();
    $pdf->AddPage('L');
    $pdf->SetFont('Helvetica','B',20);
    $pdf->Cell(40,10,'Report: ' . $_SESSION['type']);
    $pdf->Ln();
    $pdf->Ln();

//  Header
    $pdf->SetFont('Helvetica','B',12);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFillColor(206,212,236);
    $pdf->SetTextColor(0,0,0);

    while($finfo = $result->fetch_field()) {
        $pdf->Cell($w,$h,utf8_decode($finfo->name),'LTRB',0,'C',1);
    }
    $pdf->Ln();

//  Content
    $fs = ($_SESSION['type'] == 'Kundenuebersicht' ? 8 : ($_SESSION['type'] == 'Reiseuebersicht' ? 8 : 12));

    $pdf->SetFont('Helvetica','',$fs);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    while ($row = $result->fetch_assoc()) {
        foreach($row as $value) {
//            $x = $pdf->GetX();
//            $y = $pdf->GetY();
//            $pdf->MultiCell($w,$h,utf8_decode($value),'LTRB','C',1);
//            $pdf->SetXY($x + $w,$y);
            $pdf->Cell($w,$h,utf8_decode($value),'LTRB',0,'C',1);

        }
        $pdf->Ln();
    }
    $pdf->Ln();
    $pdf->Output();

} else echo "Keine Daten vorhanden zu dieser Abfrage.";
//mysqli_close($conn);