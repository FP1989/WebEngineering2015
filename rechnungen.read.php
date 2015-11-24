<?php

include("classes/database.class.php");
include("classes/rechnung.class.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();




if(isset($_POST["RechnungsID_R"])) {

    $rechnungsID = $_POST["RechnungsID_R"];

    $rechnung = $database->fetchRechnung($rechnungsID);

    $_SESSION["Rechnungsart_R"] = $rechnung->getRechnungsart();
    $_SESSION["Betrag_R"] = $rechnung->getBetrag();
    $_SESSION["Waehrung_R"] = $rechnung->getWaehrung();
    $_SESSION["IBAN_R"] = $rechnung->getIban();
    $_SESSION["SWIFT_R"] = $rechnung->getSwift();
    $_SESSION["Beguenstigter_R"] = $rechnung->getBeguenstigter();
    $_SESSION["Kostenart_R"] = $rechnung->getKostenart();
    $_SESSION["Faelligkeit_R"] = $rechnung->getFaelligkeit();
    $_SESSION["Bemerkung_R"] = $rechnung->getBemerkung();
    $_SESSION["Reise_R"] = $rechnung->getReise();
    $_SESSION["bezahlt_R"] = $rechnung->isBezahlt();

}

else if (isset($_POST["ReiseID_R"])){

    $reiseID = $_POST["ReiseID_R"];

    $result = $database->getAllRechnungen($reiseID);

    while($datensatz = $result->fetch_assoc()) $return [] = $datensatz;

    echo json_encode($return);



}



