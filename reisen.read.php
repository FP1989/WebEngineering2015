<?php

include("classes/database.class.php");
include("classes/reise.class.php");


/* @var database $database*/
$database = database::getDatabase();

if(isset($_POST["ReiseID_R"])) {

    $reiseID = $_POST["ReiseID_R"];
    $reise = $database->fetchReise($reiseID);

    $re = array();

    $re["ReiseID_R"] = $reise->getReiseID();
    $re["Ziel_R"] = $reise->getZiel();
    $re["Beschreibung_R"] =$reise->getBeschreibung();
    $re["Bezeichnung_R"] = $reise->getBezeichnung();
    $re["Preis_R"] = $reise->getPreis();
    $re["Hinreise_R"] = $reise->getHinreise();
    $re["Rueckreise_R"] = $reise->getRueckreise();

    echo json_encode($re);

}

else if(isset($_POST["Ziel_R"])){

    $ziel = $_POST["Ziel_R"];
    $reise = $database->fetchReise(null, $ziel);

    $re = array();

    $re["ReiseID_R"] = $reise->getReiseID();
    $re["Ziel_R"] = $reise->getZiel();
    $re["Beschreibung_R"] =$reise->getBeschreibung();
    $re["Bezeichnung_R"] = $reise->getBezeichnung();
    $re["Preis_R"] = $reise->getPreis();
    $re["Hinreise_R"] = $reise->getHinreise();
    $re["Rueckreise_R"] = $reise->getRueckreise();

    echo json_encode($re);

}

else {

    $result = $database->getAllReisen();

    while($datensatz = $result->fetch_assoc()) $return [] = $datensatz;

    echo json_encode($return);

}




