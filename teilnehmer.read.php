<?php

include("classes/database.class.php");
include_once("classes/teilnehmer.class.php");
include("includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();


if(isset($_POST["TeilnehmerID_R"])) {

    $teilnehmerID = $_POST["TeilnehmerID_R"];
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
}

else if(isset($_POST["Nachname_R"])){

    $nachname = $_POST["Nachname_R"];
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

