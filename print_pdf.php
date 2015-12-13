<?php
session_start();

include_once ("classes/pdf.class.php");
include_once ("classes/database.class.php");

/** @var database $verbindung */
$verbindung = database::getDatabase();
if(isset($_SESSION['radioreise'])) $result = $verbindung->generateReport($_SESSION['type'], $_SESSION['radioreise']);
else $result = $verbindung->generateReport($_SESSION['type']);

    $pdf = new PDF();
    $pdf->AddPage('L');
    $pdf->createTable($result);