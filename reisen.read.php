<?php

include("classes/database.class.php");
include("classes/reise.class.php");


/* @var database $database*/
$database = database::getDatabase();

if(isset($_POST["ReiseID_R"])) {

    $reiseID = $_POST["ReiseID_R"];
    $reise = $database->fetchReise($reiseID);

    $_POST["ReiseID_R"] = $reise->getReiseID();
    $_POST["Ziel_R"] = $reise->getZiel();
    $_POST["Beschreibung_R"] =$reise->getBeschreibung();
    $_POST["Bezeichnung_R"] = $reise->getBezeichnung();
    $_POST["Preis_R"] = $reise->getPreis();
    $_POST["Hinreise_R"] = $reise->getHinreise();
    $_POST["Rueckreise_R"] = $reise->getRueckreise();

}

if(isset($_POST["Ziel_R"])){

    $ziel = $_POST["Ziel_R"];
    $reise = $database->fetchReise(null, $ziel);

    $_POST["ReiseID_R"] = $reise->getReiseID();
    $_POST["Ziel_R"] = $reise->getZiel();
    $_POST["Beschreibung_R"] =$reise->getBeschreibung();
    $_POST["Bezeichnung_R"] = $reise->getBezeichnung();
    $_POST["Preis_R"] = $reise->getPreis();
    $_POST["Hinreise_R"] = $reise->getHinreise();
    $_POST["Rueckreise_R"] = $reise->getRueckreise();

}

else {

    $result = $database->getAlleReisen();

    while($datensatz = $result->fetch_assoc()){

        $return [] = $datensatz;

    }

    echo json_encode($return);

}




