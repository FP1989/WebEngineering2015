<?php

include("../classes/database.class.php");
include_once("../classes/rechnung.class.php");
include("../includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();

$res = array();

$rechnungsID = $_POST["RechnungsID_L"];

$success = $database->deleteRechnung($rechnungsID);

if($success) {

    $res["message"] = "Datensatz wurde gelöscht";
    $res["flag"] = true;

}

else {

    $res["flag"] = false;
    $res["message"] = "Datensatz konnte nicht gelöscht werden, möglicherweise bestehen noch Abhängigkeiten.";

}

echo json_encode($res);




