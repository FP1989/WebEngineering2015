<?php

include("../classes/database.class.php");
include_once("../classes/teilnehmer.class.php");
include("../includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();

if(is_numeric($_POST['teilnehmer'])) {

    $teilnehmerID = $_POST["teilnehmer"];
    $teilnehmer = $database->fetchTeilnehmer($teilnehmerID);

    $te = array();

    $te["TeilnehmerID_R"] = $teilnehmer->getTeilnehmerID();
    $te["Vorname_R"] = $teilnehmer->getVorname();
    $te["Nachname_R"] = $teilnehmer->getNachname();
    $te["Strasse_R"] = $teilnehmer->getStrasse();
    $te["Hausnummer_R"] = $teilnehmer->getHausnummer();
    $te["PLZ_R"] = $teilnehmer->getPlz();
    $te["Ort_R"] = $teilnehmer->getOrt();
    $te["Telefon_R"] = $teilnehmer->getTelefonNr();
    $te["Mail_R"] = $teilnehmer->getEmail();

    echo json_encode($te);

} else {

    $nachname = $_POST["teilnehmer"];
    $teilnehmer = $database->fetchTeilnehmer(null, $nachname);
    $te = array();

    $te["TeilnehmerID_R"] = $teilnehmer->getTeilnehmerID();
    $te["Vorname_R"] = $teilnehmer->getVorname();
    $te["Nachname_R"] = $teilnehmer->getNachname();
    $te["Strasse_R"] = $teilnehmer->getStrasse();
    $te["Hausnummer_R"] = $teilnehmer->getHausnummer();
    $te["PLZ_R"] = $teilnehmer->getPlz();
    $te["Ort_R"] = $teilnehmer->getOrt();
    $te["Telefon_R"] = $teilnehmer->getTelefonNr();
    $te["Mail_R"] = $teilnehmer->getEmail();

    echo json_encode($te);
}