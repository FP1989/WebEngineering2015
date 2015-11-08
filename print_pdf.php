<?php
session_start();

include_once ("classes/pdf.class.php");
include_once ("classes/database.class.php");

/** @var database $verbindung */
$verbindung = database::getDatabase();
$result = $verbindung->generateReport($_SESSION['type']);

    $pdf = new PDF();
    $pdf->AddPage('L');
    $pdf->createTable($result);