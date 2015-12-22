<?php
session_start();

include_once("../classes/pdf.class.php");
include_once("../classes/database.class.php");
include("../includes/authentication.inc.php");

/** @var database $verbindung */
$verbindung = database::getDatabase();
$result = $verbindung->generateReport($_SESSION['type'], $_SESSION['option']);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->createTable($result);