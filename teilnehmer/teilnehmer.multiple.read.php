<?php

include("../classes/database.class.php");
include_once("../classes/teilnehmer.class.php");
include("../includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();

$nachname = $_POST['teilnehmer'];
$array = array();

if(!$database->checkMultipleTeilnehmer($nachname)) echo json_encode($array);
else {
    $array = $database->checkMultipleTeilnehmer($nachname);
    echo json_encode($array);
}



