<?php

include("../classes/database.class.php");
include_once("../classes/rechnung.class.php");
include("../includes/authentication.inc.php");


/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();


if(isset($_POST["RechnungsID_R"])) {

    $rechnungsID = $_POST["RechnungsID_R"];

    $rechnung = $database->fetchRechnung($rechnungsID);

    $rg = array();

    $rg["Rechnungsart_R"] = $rechnung->getRechnungsart();
    $rg["Betrag_R"] = $rechnung->getBetrag();
    $rg["IBAN_R"] = $rechnung->getIban();
    $rg["SWIFT_R"] = $rechnung->getSwift();
    $rg["Beguenstigter_R"] = $rechnung->getBeguenstigter();
    $rg["Kostenart_R"] = $rechnung->getKostenart();
    $rg["Bemerkung_R"] = $rechnung->getBemerkung();
    $rg["Reise_R"] = $rechnung->getReise();
    $rg["bezahlt_R"] = $rechnung->isBezahlt();

    $rg["Faelligkeit_R"] = date("d.m.Y", strtotime($rechnung->getFaelligkeit()));

    echo json_encode($rg);

}

else if (isset($_POST["ReiseID_R"])){

    $reiseID = $_POST["ReiseID_R"];

    $result = $database->getAllRechnungen($reiseID);

    $returnRechnung = Array();

    if($result->num_rows == 0 ){

        $datensatz["RechnungsID"] = null;
        $returnRechnung[] = $datensatz;

    }

    else {

        while ($datensatz = $result->fetch_assoc()) {


            $beguenstigterID = $datensatz["Beguenstigter"];
            $beguenstigter = $database->fetchBeguenstigter($beguenstigterID)->getBeguenstigterName();
            $datensatz["Beguenstigter"] = $beguenstigter;
            $datensatz["Faelligkeit"] = date("d.m.Y", strtotime($datensatz["Faelligkeit"]));

            $returnRechnung [] = $datensatz;

        }
    }

    echo json_encode($returnRechnung);



}



