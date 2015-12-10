<?php

include("classes/database.class.php");
include("classes/rechnung.class.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();


if(isset($_POST["RechnungsID_R"])) {

    $rechnungsID = $_POST["RechnungsID_R"];

    $rechnung = $database->fetchRechnung($rechnungsID);

    $rg = array();

    $rg["Rechnungsart_R"] = $rechnung->getRechnungsart();
    $rg["Betrag_R"] = $rechnung->getBetrag();
    $rg["Waehrung_R"] = $rechnung->getWaehrung();
    $rg["IBAN_R"] = $rechnung->getIban();
    $rg["SWIFT_R"] = $rechnung->getSwift();
    $rg["Beguenstigter_R"] = $rechnung->getBeguenstigter();
    $rg["Kostenart_R"] = $rechnung->getKostenart();
    $rg["Bemerkung_R"] = $rechnung->getBemerkung();
    $rg["Reise_R"] = $rechnung->getReise();
    $rg["bezahlt_R"] = $rechnung->isBezahlt();
    $date = date("d-m-Y", strtotime($rechnung->getFaelligkeit()));
    $rg["Faelligkeit_R"] = $date;

    echo json_encode($rg);

}

else if (isset($_POST["ReiseID_R"])){

    $reiseID = $_POST["ReiseID_R"];

    $result = $database->getAllRechnungen($reiseID);

    while($datensatz = $result->fetch_assoc()){


        $beguenstigterID = $datensatz["Beguenstigter"];
        $beguenstigter = $database->fetchBeguenstigter($beguenstigterID)->getBeguenstigterName();

        $faelligkeit = $datensatz["Faelligkeit"];
        $date = date("d-m-Y", strtotime($faelligkeit));
        $datensatz["Faelligkeit"] = $date;
        $datensatz["Beguenstigter"] = $beguenstigter;

        $returnRechnung [] = $datensatz;

    }

    echo json_encode($returnRechnung);



}



