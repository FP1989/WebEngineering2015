<?php

include("classes/database.class.php");
include("classes/rechnung.class.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();


if(isset($_POST["RechnungsID_R"])) {

    $rechnungsID = $_POST["RechnungsID_R"];

    $rechnung = $database->fetchRechnung($rechnungsID);

    $result = array();

    $result["Rechnungsart_R"]= $rechnung->getRechnungsart();
    $result["Betrag_R"]= $rechnung->getBetrag();
    $result["Waehrung_R"] = $rechnung->getWaehrung();
    $result["IBAN_R"] = $rechnung->getIban();
    $result["Swift_R"] = $rechnung->getSwift();
    $result["Beguenstigter_R"] = $rechnung->getBeguenstigter();
    $result["Kostenart_R"] = $rechnung->getKostenart();
    $result["Faelligkeit_R"] = $rechnung->getFaelligkeit();
    $result["Bemerkung_R"] = $rechnung->getBemerkung();
    $result["ReiseID_R"]= $rechnung->getReise();
    $result["bezahlt_R"]  = $rechnung->isBezahlt();

    /* echo json_encode($result); */

}

else if (isset($_POST["ReiseID_R"])){

    $reiseID = $_POST["ReiseID_R"];

    $result = $database->getAllRechnungen($reiseID);

    while($datensatz = $result->fetch_assoc()){


        $beguenstigterID = $datensatz["Beguenstigter"];
        $beguenstigter = $database->fetchBeguenstigter($beguenstigterID)->getBeguenstigterName();

        $datensatz["Beguenstigter"] = $beguenstigter;

        $returnRechnung [] = $datensatz;

    }

    echo json_encode($returnRechnung);



}



