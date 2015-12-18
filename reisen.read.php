<?php

include("classes/database.class.php");
include_once("classes/reise.class.php");


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


    $date = date("d-m-Y", strtotime($reise->getHinreise()));
    @$rueckreise_array = explode('-', $date);
    @$tag = $rueckreise_array[0];
    @$monat = $rueckreise_array[1];
    @$jahr = $rueckreise_array[2];
    $newDate = $tag . "." . $monat . "." . $jahr;
    $re["Hinreise_R"] = $newDate;

    $date = date("d-m-Y", strtotime($reise->getRueckreise()));
    @$rueckreise_array = explode('-', $date);
    @$tag = $rueckreise_array[0];
    @$monat = $rueckreise_array[1];
    @$jahr = $rueckreise_array[2];
    $newDate = $tag . "." . $monat . "." . $jahr;
    $re["Rueckreise_R"] = $newDate;

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

    $date = date("d-m-Y", strtotime($reise->getHinreise()));
    @$hinreise_array = explode('-', $date);
    @$tag = $hinreise_array[0];
    @$monat = $hinreise_array[1];
    @$jahr = $hinreise_array[2];
    $newDate = $tag . "." . $monat . "." . $jahr;
    $re["Hinreise_R"] = $newDate;

    $date = date("d-m-Y", strtotime($reise->getRueckreise()));
    @$rueckreise_array = explode('-', $date);
    @$tag = $rueckreise_array[0];
    @$monat = $rueckreise_array[1];
    @$jahr = $rueckreise_array[2];
    $newDate = $tag . "." . $monat . "." . $jahr;
    $re["Rueckreise_R"] = $newDate;

    echo json_encode($re);

}

else if(isset($_POST["timespan"])){

        $result = $database->getAllReisen($_POST["timespan"]);

        while($datensatz = $result->fetch_assoc()){


        $date = date("d-m-Y", strtotime($datensatz["Hinreise"]));
        @$hinreise_array = explode('-', $date);
        @$tag = $hinreise_array[0];
        @$monat = $hinreise_array[1];
        @$jahr = $hinreise_array[2];
        $newDate = $tag . "." . $monat . "." . $jahr;
        $datensatz["Hinreise"] = $newDate;

        $date = date("d-m-Y", strtotime($datensatz["Rueckreise"]));
        @$rueckreise_array = explode('-', $date);
        @$tag = $rueckreise_array[0];
        @$monat = $rueckreise_array[1];
        @$jahr = $rueckreise_array[2];
        $newDate = $tag . "." . $monat . "." . $jahr;
        $datensatz["Rueckreise"] = $newDate;

        $return [] = $datensatz;
    }

    echo json_encode($return);

}




