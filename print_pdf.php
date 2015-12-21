<?php
session_start();

include_once ("classes/pdf.class.php");
include_once ("classes/database.class.php");
include("includes/authentication.inc.php");

/** @var database $verbindung */
$verbindung = database::getDatabase();
if(isset($_SESSION['reisekonkret'])) $result = $verbindung->generateReport($_SESSION['type'], $_SESSION['reisekonkret']);
else $result = $verbindung->generateReport($_SESSION['type']);

    $pdf = new PDF();
    $pdf->AddPage('L');
    $pdf->createTable($result);