<?php

include("../classes/database.class.php");
include_once("../classes/teilnehmer.class.php");
include("../includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();


if(isset($_POST["BeguenstigterID_R"])) {

    $beguenstigterID = $_POST["BeguenstigterID_R"];
    $beguenstigter = $database->fetchBeguenstigter($beguenstigterID);

    $beg = array();

    $beg["BeguenstigterID_R"] = $beguenstigter->getBeguenstigterID();
    $beg["Name_R"] = $beguenstigter->getBeguenstigterName();
    $beg["Strasse_R"] = $beguenstigter->getStrasse();
    $beg["Hausnummer_R"] = $beguenstigter->getHausnummer();
    $beg["Ort_R"] = $beguenstigter->getOrt();
    $beg["PLZ_R"] = $beguenstigter->getPlz();

    echo json_encode($beg);
}

else if(isset($_POST["Name_R"])){

    $name = $_POST["Name_R"];
    $beguenstigter = $database->fetchBeguenstigter(null, $name);

    $beg = array();

    $beg["BeguenstigterID_R"] = $beguenstigter->getBeguenstigterID();
    $beg["Name_R"] = $beguenstigter->getBeguenstigterName();
    $beg["Strasse_R"] = $beguenstigter->getStrasse();
    $beg["Hausnummer_R"] = $beguenstigter->getHausnummer();
    $beg["Ort_R"] = $beguenstigter->getOrt();
    $beg["PLZ_R"] = $beguenstigter->getPlz();

    echo json_encode($beg);

}