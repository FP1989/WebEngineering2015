<?php

include("classes/database.class.php");
include("classes/reisen.class.php");



/* @var database $database*/
$database = database::getDatabase();

if(isset($_POST["ReiseID_R"])) {

    $reiseID = $_POST["ReiseID_R"];
    $reise = $database->fetchReise($reiseID);

}

else{

    $ziel = $_POST["Ziel_R"];
    $reise = $database->fetchReise(null, $ziel);

}

$_POST["ReiseID"] = $reise->getReiseID();
$_POST["Ziel_R"] = $reise->getZiel();
$_POST["Beschreibung_R"] =$reise->getBeschreibung();
$_POST["Bezeichnung_R"] = $reise->getBezeichnung();
$_POST["Preis_R"] = $reise->getPreis();
$_POST["Hinreise_R"] = $reise->getHinreise();
$_POST["Rueckreise_R"] = $reise->getRueckreise();



