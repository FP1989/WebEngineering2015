<?php

include("classes/database.class.php");
include("classes/reise.class.php");


/* @var database $database*/
$database = database::getDatabase();

if(isset($_POST["ReiseID_R"])) {

    $reiseID = $_POST["ReiseID_R"];
    $reise = $database->fetchReise($reiseID);

    $_SESSION["ReiseID_R"] = $reise->getReiseID();
    $_SESSION["Ziel_R"] = $reise->getZiel();
    $_SESSION["Beschreibung_R"] =$reise->getBeschreibung();
    $_SESSION["Bezeichnung_R"] = $reise->getBezeichnung();
    $_SESSION["Preis_R"] = $reise->getPreis();
    $_SESSION["Hinreise_R"] = $reise->getHinreise();
    $_SESSION["Rueckreise_R"] = $reise->getRueckreise();

}

if(isset($_POST["Ziel_R"])){

    $ziel = $_POST["Ziel_R"];
    $reise = $database->fetchReise(null, $ziel);

    $_SESSION["ReiseID_R"] = $reise->getReiseID();
    $_SESSION["Ziel_R"] = $reise->getZiel();
    $_SESSION["Beschreibung_R"] =$reise->getBeschreibung();
    $_SESSION["Bezeichnung_R"] = $reise->getBezeichnung();
    $_SESSION["Preis_R"] = $reise->getPreis();
    $_SESSION["Hinreise_R"] = $reise->getHinreise();
    $_SESSION["Rueckreise_R"] = $reise->getRueckreise();

}

else {

    $result = $database->getAllReisen();

    while($datensatz = $result->fetch_assoc()) $return [] = $datensatz;

    echo json_encode($return);

}




