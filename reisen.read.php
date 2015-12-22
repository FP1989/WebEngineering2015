<?php

include("classes/database.class.php");
include_once("classes/reise.class.php");
include("includes/authentication.inc.php");

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
    $re["Maximalanzahl_R"] = $reise->getMaxAnzahl();
    $re["Mindestanzahl_R"] = $reise->getMinAnzahl();


    $re["Hinreise_R"] = date("d-m-Y", strtotime($reise->getHinreise()));

    $re["Rueckreise_R"] = date("d-m-Y", strtotime($reise->getRueckreise()));

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
    $re["Maximalanzahl_R"] = $reise->getMaxAnzahl();
    $re["Mindestanzahl_R"] = $reise->getMinAnzahl();

    $re["Hinreise_R"] = date("d.m.Y", strtotime($reise->getHinreise()));

    $re["Rueckreise_R"] = date("d.m.Y", strtotime($reise->getRueckreise()));

    echo json_encode($re);

}

else if(isset($_POST["timespan"])){

        $result = $database->getAllReisen($_POST["timespan"]);

        $return = array();

        while($datensatz = $result->fetch_assoc()){

            $datensatz["Hinreise"] = date("d.m.Y", strtotime($datensatz["Hinreise"]));
            $datensatz["Rueckreise"] = date("d.m.Y", strtotime($datensatz["Rueckreise"]));

            $return [] = $datensatz;
        }

    echo json_encode($return);

}




