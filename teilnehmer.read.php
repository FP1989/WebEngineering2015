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

$_SESSION["TeilnehmerID_R"] = $teilnehmer->getTeilnehmerID();
$_SESSION["Vorname_R"] = $teilnehmer->getVorname();
$_SESSION["Nachname_R"] = $teilnehmer->getNachname();
$_SESSION["Strasse_R"] = $teilnehmer->getStrasse();
$_SESSION["Hausnummer_R"] = $teilnehmer->getHausnummer();
$_SESSION["PLZ_R"] = $teilnehmer->getPlz();
$_SESSION["Ort_R"] = $teilnehmer->getOrt();
$_SESSION["Telefon_R"] = $teilnehmer->getTelefonNr();
$_SESSION["Mail_R"] = $teilnehmer->getEmail();



