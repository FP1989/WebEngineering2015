<?php

include("classes/database.class.php");
include("classes/teilnehmer.class.php");

/* @var database $database*/
$database = database::getDatabase();

if(isset($_POST["TeilnehmerID_R"])) {

    $teilnehmerID = $_POST["TeilnehmerID_R"];
    $teilnehmer = $database->fetchTeilnehmer($teilnehmerID);

}

else{

    $nachname = $_POST["Nachname_R"];
    $teilnehmer = $database->fetchTeilnehmer(null, $nachname);

}

$_POST["TeilnehmerID_R"] = $teilnehmer->getTeilnehmerID();
$_POST["Vorname_R"] = $teilnehmer->getVorname();
$_POST["Nachname_R"] = $teilnehmer->getNachname();
$_POST["Strasse_R"] = $teilnehmer->getStrasse();
$_POST["Hausnummer_R"] = $teilnehmer->getHausnummer();
$_POST["PLZ_R"] = $teilnehmer->getPlz();
$_POST["Ort_R"] = $teilnehmer->getOrt();
$_POST["Telefon_R"] = $teilnehmer->getTelefonNr();
$_POST["Mail_R"] = $teilnehmer->getEmail();



