<?php

include("classes/database.class.php");
include("classes/rechnung.class.php");

$rechnungsID = $_POST["RechnungsID_R"];

/* @var database $database*/
$database = database::getDatabase();

$rechnung = $database->fetchRechnung($rechnungsID);

$_POST["Rechnungsart_R"] = $rechnung->getRechnungsart();
$_POST["Betrag_R"] = $rechnung->getBetrag();
$_POST["Waehrung_R"] = $rechnung->getWaehrung();
$_POST["IBAN_R"] = $rechnung->getIban();
$_POST["SWIFT_R"] = $rechnung->getSwift();
$_POST["Beguenstigter_R"] = $rechnung->getBeguenstigter();
$_POST["Kostenart_R"] = $rechnung->getKostenart();
$_POST["Faelligkeit_R"] = $rechnung->getFaelligkeit();
$_POST["Bemerkung_R"] = $rechnung->getBemerkung();
$_POST["Reise_R"] = $rechnung->getReise();
$_POST["bezahlt_R"] = $rechnung->isBezahlt();


